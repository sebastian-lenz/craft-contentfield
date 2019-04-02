<?php

namespace sebastianlenz\contentfield\services;

use craft\elements\Asset;

use sebastianlenz\contentfield\services\imageTags\DefaultImageTag;
use sebastianlenz\contentfield\services\imageTags\PictureImageTag;
use sebastianlenz\contentfield\services\imageTags\ImageTag;
use sebastianlenz\contentfield\services\imageTags\WrappedImageTag;

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
   * List of attributes known to contain transform names.
   */
  const TRANSFORM_ATTRIBUTES = [
    'fallbackTransform',
    'inlineTransform',
    'transforms'
  ];


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
      foreach (self::TRANSFORM_ATTRIBUTES as $attribute) {
        if (!array_key_exists($attribute, $definition)) {
          continue;
        }

        $values = $definition[$attribute];
        if (is_string($values)) {
          $values = [$values];
        }

        if (!is_array($values)) {
          continue;
        }

        foreach ($values as $value) {
          if (
            is_string($value) &&
            !in_array($value, $transforms) &&
            $value != ImageTag::ORIGINAL_TRANSFORM
          ) {
            $transforms[] = $value;
          }
        }
      }
    }

    return $transforms;
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
   * @return string|null
   * @throws \Exception
   */
  public function render(Asset $asset, $config) {
    if (!is_array($config)) {
      $config = array('type' => (string)$config);
    }

    $config = $this->resolveDefinition($config);
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
