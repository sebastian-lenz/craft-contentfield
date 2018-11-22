<?php

namespace contentfield\services\imageTags;

use craft\elements\Asset;
use yii\base\BaseObject;

/**
 * Interface ImageTag
 */
abstract class ImageTag extends BaseObject
{
  /**
   * @var Asset
   */
  public $asset;


  /**
   * @return boolean
   */
  abstract function isSupported();

  /**
   * @return string
   */
  abstract function render();

  /**
   * @param array $attributes
   * @param array $values
   * @return array
   */
  protected function expandAttributes($attributes, $values = array()) {
    $asset = $this->asset;
    $focalPoint = $asset->getFocalPoint() ?? ['x' => 0.5, 'y' => 0.5];

    $values += array(
      '$focusX'       => $focalPoint['x'],
      '$focusY'       => $focalPoint['y'],
      '$nativeWidth'  => $asset->getWidth(),
      '$nativeHeight' => $asset->getHeight(),
      '$title'        => $asset->title,
    );

    $result = array();
    foreach ($attributes as $key => $value) {
      if (array_key_exists($value, $values)) {
        $result[$key] = is_callable($values[$value])
          ? $values[$value]()
          : $values[$value];
      } else {
        $result[$key] = $value;
      }
    }

    return $result;
  }

  /**
   * @param string|array|null $transform
   * @return array
   */
  protected function toSource($transform = null) {
    return array(
      'height' => $this->asset->getHeight($transform),
      'src'    => $this->asset->getUrl($transform),
      'width'  => $this->asset->getWidth($transform)
    );
  }

  /**
   * @param string|array|null $transforms
   * @return array
   */
  protected function toSources($transforms = null) {
    $sources = array();

    if (is_string($transforms)) {
      $transforms = explode(',', $transforms);
    }

    if (!is_array($transforms) || count($transforms) === 0) {
      $sources[] = $this->toSource();
    } else {
      foreach ($transforms as $transform) {
        $source = $this->toSource($transform);
        if (!is_null($source)) {
          $sources[] = $source;
        }
      }
    }

    usort($sources, function($left, $right) {
      return $left['width'] - $right['width'];
    });

    return $sources;
  }

  /**
   * @var array $attributes
   * @var boolean $useSourceSet
   * @return array
   */
  static public function ensureSourceAttribute($attributes, $useSourceSet = false) {
    if (!self::hasSourceAttribute($attributes)) {
      if ($useSourceSet) {
        $attributes['srcset'] = '$srcset';
      } else {
        $attributes['src'] = '$src';
      }
    }

    return $attributes;
  }

  /**
   * @var array $attributes
   * @return boolean
   */
  static public function hasSourceAttribute($attributes) {
    foreach ($attributes as $attribute) {
      if ($attribute === '$src' || $attribute === '$srcset') {
        return true;
      }
    }

    return false;
  }

  /**
   * @param mixed $target
   * @param mixed $source
   * @param string|string[] $keys
   * @return array
   */
  static protected function mergeAttributes($target, $source, $keys = 'attributes') {
    if (!is_array($target)) $target = array();
    if (!is_array($source)) $source = array();
    if (!is_array($keys)) $keys = array($keys);

    foreach ($keys as $key) {
      $hasTarget = array_key_exists($key, $target);
      $hasSource = array_key_exists($key, $source);

      if ($hasTarget && $hasSource) {
        $target[$key] = self::mergeClassNames($target[$key], $source[$key]) + $source[$key];
      } elseif ($hasSource) {
        $target[$key] = $source[$key];
      }
    }

    return $target;
  }

  /**
   * @param array $target
   * @param array $source
   * @return array
   */
  static public function mergeConfig($target, $source) {
    return $target + $source;
  }

  /**
   * @param array $target
   * @param array $source
   * @param string $key
   * @return array
   */
  static protected function mergeClassNames($target, $source, $key = 'class') {
    $hasTarget = array_key_exists($key, $target);
    $hasSource = array_key_exists($key, $source);

    if ($hasTarget && $hasSource) {
      $target[$key] = implode(' ', array_unique(array_merge(
        explode(' ', $source[$key]),
        explode(' ', $target[$key])
      )));
    } elseif ($hasSource) {
      $target[$key] = $source[$key];
    }

    return $target;
  }

  /**
   * @param array $sources
   * @return string
   */
  static protected function toSourceSet($sources) {
    $maxSource = array_pop($sources);
    $srcSet = array();
    foreach ($sources as $source) {
      $srcSet[] = $source['src'] . ' ' . $source['width'] . 'w';
    }

    $srcSet[] = $maxSource['src'];
    return implode(',', $srcSet);
  }
}
