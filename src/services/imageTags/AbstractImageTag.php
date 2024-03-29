<?php

namespace lenz\contentfield\services\imageTags;

use craft\elements\Asset;
use craft\helpers\Image;
use lenz\contentfield\services\imageTags\sources\Source;
use lenz\contentfield\services\imageTags\sources\SourceGroupSet;
use lenz\contentfield\services\imageTags\sources\SourceSet;
use yii\base\BaseObject;

/**
 * Class AbstractImageTag
 */
abstract class AbstractImageTag extends BaseObject implements ImageTagInterface
{
  /**
   * @var mixed
   */
  public mixed $transformGroups = null;

  /**
   * @var mixed
   */
  public mixed $transforms = null;

  /**
   * @var Asset
   */
  private Asset $_asset;

  /**
   * @var Source
   */
  private Source $_nativeImage;

  /**
   * @var SourceGroupSet
   */
  private SourceGroupSet $_sourceGroups;

  /**
   * @var SourceSet
   */
  private SourceSet $_sources;


  /**
   * ImageImageTag constructor.
   *
   * @param Asset $asset
   * @param array $config
   */
  public function __construct(Asset $asset, array $config) {
    parent::__construct(self::expandConfig($config));

    $this->_asset = $asset;
    $this->_nativeImage = new Source($this->_asset);
  }

  /**
   * @return Asset
   */
  public function getAsset(): Asset {
    return $this->_asset;
  }

  /**
   * @return Source
   */
  public function getNativeImage(): Source {
    return $this->_nativeImage;
  }

  /**
   * @return bool
   */
  public function isSupported(): bool {
    $ext = $this->_asset->getExtension();
    return Image::canManipulateAsImage($ext);
  }


  // Protected methods
  // -----------------

  /**
   * @return SourceGroupSet
   */
  protected function getSourceGroups(): SourceGroupSet {
    if (!isset($this->_sourceGroups)) {
      $this->_sourceGroups = new SourceGroupSet(
        $this->_nativeImage,
        $this->transformGroups
      );
    }

    return $this->_sourceGroups;
  }

  /**
   * @return SourceSet
   */
  protected function getSources(): SourceSet {
    if (empty($this->transforms)) {
      return $this->getSourceGroups()->getSources();
    }

    if (!isset($this->_sources)) {
      $this->_sources = new SourceSet($this->getNativeImage(), $this->transforms);
    }

    return $this->_sources;
  }


  // Static methods
  // --------------

  /**
   * Expand the given config array.
   *
   * @param array $config
   * @return array
   */
  static public function expandConfig(array &$config): array {
    foreach ($config as $key => &$value) {
      if (!is_numeric($key) && $key !== 'transform') {
        continue;
      }

      if (
        isset($config['transforms']) &&
        !is_array($config['transforms']))
      {
        $config['transforms'] = [$config['transforms']];
      }

      unset($config[$key]);
      $config['transforms'][] = $value;
    }

    if (
      array_key_exists('transformGroups', $config) &&
      is_array($config['transformGroups'])
    ) {
      foreach ($config['transformGroups'] as &$group) {
        if (is_array($group)) {
          self::expandConfig($group);
        }
      }
    }

    return $config;
  }

  /**
   * @param array $config
   * @param array $parent
   * @return array
   */
  static public function mergeConfig(array $config, array $parent): array {
    self::expandConfig($parent);
    self::expandConfig($config);

    return array_merge($parent, $config);
  }
}
