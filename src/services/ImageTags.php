<?php

namespace lenz\contentfield\services;

use craft\elements\Asset;

use lenz\contentfield\services\imageTags\DefaultImageTag;
use lenz\contentfield\services\imageTags\PictureImageTag;
use lenz\contentfield\services\imageTags\ImageTag;
use lenz\contentfield\services\imageTags\WrappedImageTag;

/**
 * Class ImageTags
 */
class ImageTags extends AbstractDefinitionService
{
  /**
   * @var ImageTag[]
   */
  private $imageTags;


  /**
   * ImageTags constructor.
   */
  public function __construct() {
    $this->imageTags = array(
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
    $this->imageTags[$type] = $imageTagClass;
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
      foreach ($this->imageTags as $imageTag) {
        $transforms = array_merge(
          $transforms,
          $imageTag::extractTransforms($definition)
        );
      }
    }

    return array_unique($transforms);
  }

  /**
   * @inheritDoc
   */
  protected function getCacheKey() {
    return 'CONTENTFIELD_DEFS:IMAGETAGS';
  }

  /**
   * @return string
   */
  protected function getDefinitionName() {
    return 'imagetags';
  }

  /**
   * @param $config
   * @return ImageTag|mixed
   * @throws \Exception
   */
  protected function getImageTagClass($config) {
    $type = $config['type'];
    if (!array_key_exists($type, $this->imageTags)) {
      throw new \Exception('Invalid image tag type: ' .  $type);
    }

    return $this->imageTags[$type];
  }

  /**
   * @param string $type
   * @return boolean
   */
  protected function isNativeType($type) {
    return array_key_exists($type, $this->imageTags);
  }

  /**
   * @param array $config
   * @param array $definition
   * @return array
   * @throws \Exception
   */
  protected function mergeDefinitions($config, $definition) {
    $imageTagClass = $this->getImageTagClass($definition);
    return $imageTagClass::mergeConfig($config, $definition);
  }

  /**
   * @param Asset $asset
   * @param array $config
   * @param array|null $extraConfig
   * @return string|null
   * @throws \Exception
   */
  public function render(Asset $asset, $config, $extraConfig = null) {
    if (!is_array($config)) {
      $config = array('type' => (string)$config);
    }

    $config = $this->resolveDefinition($config);
    if (!is_null($extraConfig)) {
      if (!isset($extraConfig['type'])) {
        $extraConfig['type'] = $config['type'];
      }
      $config = $this->mergeDefinitions($config, $extraConfig);
    }

    $imageTagClass = $this->getImageTagClass($config);
    $config['asset'] = $asset;
    unset($config['type']);

    $imageTag = new $imageTagClass($config);
    if (!($imageTag instanceof ImageTag)) {
      throw new \Exception('Invalid image tag class ' .  $imageTagClass . ' for type ' . $type);
    }

    return $imageTag->isSupported()
      ? $imageTag->render()
      : null;
  }
}
