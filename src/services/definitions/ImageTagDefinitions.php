<?php

namespace lenz\contentfield\services\definitions;

use craft\elements\Asset;
use craft\helpers\Json;
use Exception;
use lenz\contentfield\Plugin;
use lenz\contentfield\services\imageTags\ConfigImageTag;
use lenz\contentfield\services\imageTags\ImageImageTag;
use lenz\contentfield\services\imageTags\ImageTagInterface;
use lenz\contentfield\services\imageTags\ImageTransformExtractorInterface;
use lenz\contentfield\services\imageTags\PictureImageTag;
use lenz\contentfield\services\imageTags\TemplateImageTag;
use yii\caching\TagDependency;

/**
 * Class ImageTagDefinitions
 */
class ImageTagDefinitions extends AbstractDefinitions
{
  /**
   * @var ImageTagInterface[]|string[]
   */
  private $_imageTags;


  /**
   * ImageTags constructor.
   */
  public function __construct() {
    $this->_imageTags = array(
      'config'   => ConfigImageTag::class,
      'image'    => ImageImageTag::class,
      'picture'  => PictureImageTag::class,
      'template' => TemplateImageTag::class,
    );
  }

  /**
   * @return array
   */
  public function getAllTransforms() {
    if (!isset($this->definitions)) {
      $this->loadDefinitions();
    }

    $allTransforms = [];
    foreach ($this->_imageTags as $imageTag) {
      if (!($imageTag instanceof ImageTransformExtractorInterface)) {
        continue;
      }

      foreach ($this->definitions as $definition) {
        $allTransforms = array_merge(
          $allTransforms,
          $imageTag::extractTransforms($definition)
        );
      }
    }

    $result = [];
    foreach ($allTransforms as $transform) {
      foreach ($result as $existingTransform) {
        if ($existingTransform == $transform) {
          continue 2;
        }
      }

      $result[] = $transform;
    }

    return $result;
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
      $config['type'] = 'image';
    }

    $config   = $this->resolveDefinition($config);
    $cache    = Plugin::getInstance()->imageTagCache;
    $cacheKey = __METHOD__ . '(' . md5(Json::encode([
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

  /**
   * @param string $type
   * @param string $imageTagClass
   */
  public function registerImageTag($type, $imageTagClass) {
    $this->_imageTags[$type] = $imageTagClass;
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
   * @param array $config
   * @return ImageTagInterface|mixed
   * @throws Exception
   */
  protected function getImageTagClass(array $config) {
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
    $imageTagClass = $this->getImageTagClass($config);
    $type = $config['type'];
    unset($config['type']);

    $imageTag = new $imageTagClass($asset, $config);

    if (!($imageTag instanceof ImageTagInterface)) {
      throw new Exception(sprintf(
        'Invalid image tag class `%s` for type %s.', $imageTagClass, $type)
      );
    }

    return $imageTag->isSupported()
      ? $imageTag->render()
      : null;
  }
}
