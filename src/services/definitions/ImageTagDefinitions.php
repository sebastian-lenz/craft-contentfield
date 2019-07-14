<?php

namespace lenz\contentfield\services\definitions;

use craft\elements\Asset;
use Exception;
use lenz\contentfield\services\imageTags\DefaultImageTag;
use lenz\contentfield\services\imageTags\ImageTag;
use lenz\contentfield\services\imageTags\PictureImageTag;
use lenz\contentfield\services\imageTags\WrappedImageTag;

/**
 * Class ImageTagDefinitions
 */
class ImageTagDefinitions extends AbstractDefinitions
{
  /**
   * @var ImageTag[]
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
   * @param array|null $extraConfig
   * @return string|null
   * @throws Exception
   */
  public function render(Asset $asset, $config, $extraConfig = null) {
    if (!is_array($config)) {
      $config = [
        'type' => (string)$config
      ];
    }

    $config = $this->resolveDefinition($config);
    if (!is_null($extraConfig)) {
      if (!isset($extraConfig['type'])) {
        $extraConfig['type'] = $config['type'];
      }

      $config = $this->mergeDefinitions($extraConfig, $config);
    }

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
}
