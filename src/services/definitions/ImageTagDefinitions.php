<?php

namespace lenz\contentfield\services\definitions;

use Craft;
use craft\elements\Asset;
use craft\helpers\Json;
use Exception;
use lenz\contentfield\Plugin;
use lenz\contentfield\services\imageTags\DefaultImageTag;
use lenz\contentfield\services\imageTags\ImageTag;
use lenz\contentfield\services\imageTags\PictureImageTag;
use lenz\contentfield\services\imageTags\WrappedImageTag;
use yii\caching\TagDependency;

/**
 * Class ImageTagDefinitions
 */
class ImageTagDefinitions extends AbstractDefinitions
{
  /**
   * @var ImageTag[]|string[]
   */
  private $_imageTags;


  /**
   * ImageTags constructor.
   */
  public function __construct() {
    $this->_imageTags = array(
      'default' => DefaultImageTag::class,
      'picture' => PictureImageTag::class,
      'wrapped' => WrappedImageTag::class
    );
  }

  /**
   * @param string $type
   * @param string $imageTagClass
   */
  public function addImageTag($type, $imageTagClass) {
    $this->_imageTags[$type] = $imageTagClass;
  }

  /**
   * @return array
   */
  public function getAllTransforms() {
    if (!isset($this->definitions)) {
      $this->loadDefinitions();
    }

    $transforms = array();
    foreach ($this->definitions as $definition) {
      foreach ($this->_imageTags as $imageTag) {
        $transforms = array_merge(
          $transforms,
          $imageTag::extractTransforms($definition)
        );
      }
    }

    return $transforms;
  }

  /**
   * @param Asset $asset
   * @param array|string $config
   * @return string|null
   * @throws Exception
   */
  public function render(Asset $asset, $config) {
    if (!is_array($config)) {
      $config = [
        'type' => (string)$config
      ];
    }

    if (!array_key_exists('type', $config)) {
      $config['type'] = 'default';
    }

    $config   = $this->resolveDefinition($config);
    $cache    = Plugin::getInstance()->imageTagCache;
    $cacheKey = self::class . '::render(' . md5(Json::encode([
      'asset'  => $asset->uid,
      'mtime'  => $asset->dateModified,
      'config' => $config,
    ])) . ')';

    $result = $cache->get($cacheKey);
    if ($result !== false) {
      return $result;
    }

    $result = $this->renderInternal($asset, $config);
    if (strpos($result, 'actions/assets/generate-transform') === false) {
      $cache->set($cacheKey, $result, null, new TagDependency(['tags' => $asset->uid]));
    }

    return $result;
  }


  // Protected methods
  // -----------------

  /**
   * @return string
   */
  protected function getDefinitionName() {
    return 'imagetags';
  }

  /**
   * @param $config
   * @return ImageTag|mixed
   * @throws Exception
   */
  protected function getImageTagClass($config) {
    $type = $config['type'];
    if (!array_key_exists($type, $this->_imageTags)) {
      throw new Exception('Invalid image tag type: ' .  $type);
    }

    return $this->_imageTags[$type];
  }

  /**
   * @param string $type
   * @return boolean
   */
  protected function isNativeType($type) {
    return array_key_exists($type, $this->_imageTags);
  }

  /**
   * @param array $config
   * @param array $parent
   * @return array
   * @throws Exception
   */
  protected function mergeDefinitions(array $config, array $parent) {
    $imageTagClass = $this->getImageTagClass($parent);
    return $imageTagClass::mergeConfig($config, $parent);
  }

  /**
   * @param Asset $asset
   * @param array $config
   * @return string|null
   * @throws Exception
   */
  protected function renderInternal(Asset $asset, array $config) {
    $imageTagClass   = $this->getImageTagClass($config);
    $type            = $config['type'];
    $config['asset'] = $asset;

    unset($config['type']);

    $imageTag = new $imageTagClass($config);
    if (!($imageTag instanceof ImageTag)) {
      throw new Exception(sprintf(
        'Invalid image tag class `%s` for type %s.', $imageTagClass, $type)
      );
    }

    return $imageTag->isSupported()
      ? $imageTag->render()
      : null;
  }
}
