<?php

namespace lenz\contentfield\services\imageTags;

use Craft;
use craft\elements\Asset;
use craft\errors\AssetException;
use craft\errors\AssetTransformException;
use craft\helpers\Image;
use Throwable;
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
   * @var string
   */
  public $thumbnailTransform;

  /**
   * Transform handle used to indicate original transform.
   */
  const ORIGINAL_TRANSFORM = '$original';


  /**
   * @return string|null
   * @throws AssetException
   * @throws AssetTransformException
   */
  public function getThumbnail() {
    $asset = $this->asset;
    $volume = $asset->volume;

    if (
      $this->thumbnailTransform === null ||
      !Image::canManipulateAsImage(pathinfo($asset->filename, PATHINFO_EXTENSION)))
    {
      return null;
    }

    $transforms = Craft::$app->getAssetTransforms();
    $index = $transforms->getTransformIndex($asset, $this->thumbnailTransform);
    if (!$index->fileExists) {
      try {
        $transforms->ensureTransformUrlByIndexModel($index);
      } catch (Throwable $exception) {
        if (!is_null($index->id)) {
          $transforms->deleteTransformIndex($index->id);
        }
        return null;
      }
    }

    $stream = $volume->getFileStream(
      $asset->folderPath .
      $transforms->getTransformSubpath($this->asset, $index)
    );

    return "url('data:image/gif;base64," . base64_encode(stream_get_contents($stream)) . "')";
  }

  /**
   * @return string
   */
  public function getThumbnailStyle() {
    try {
      $thumbnail = $this->getThumbnail();
      return is_null($thumbnail) ? '' : 'background-image:' . $thumbnail . ';';
    } catch (Throwable $error) {
      return '';
    }
  }

  /**
   * @return boolean
   */
  abstract function isSupported();

  /**
   * @return string
   */
  abstract function render();


  // Protected methods
  // -----------------

  /**
   * @param array $attributes
   * @param array $values
   * @return array
   */
  protected function expandAttributes($attributes, $values = array()) {
    $asset      = $this->asset;
    $focalPoint = $asset->getFocalPoint() ?? ['x' => 0.5, 'y' => 0.5];
    $result     = array();

    $values += array(
      '$focusX'         => $focalPoint['x'],
      '$focusY'         => $focalPoint['y'],
      '$nativeHeight'   => [$asset, 'getHeight'],
      '$nativeSrc'      => [$asset, 'getUrl'],
      '$nativeWidth'    => [$asset, 'getWidth'],
      '$title'          => $asset->title,
      '$thumbnail'      => [$this, 'getThumbnail'],
      '$thumbnailStyle' => [$this, 'getThumbnailStyle'],
    );

    uksort($values, function($left, $right) {
      return strlen($right) - strlen($left);
    });

    foreach ($attributes as $attributeName => $attribute) {
      foreach ($values as $valueName => $value) {
        if (strpos($attribute, $valueName) === false) {
          continue;
        }

        $resolvedValue = is_callable($value) ? $value() : $value;
        $attribute = str_replace($valueName, $resolvedValue, $attribute);
      }

      $result[$attributeName] = $attribute;
    }

    return $result;
  }

  /**
   * @param string|array|null $transform
   * @return array
   */
  protected function toSource($transform = null) {
    if ($transform == self::ORIGINAL_TRANSFORM) {
      $transform = null;
    }

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
    $transforms = self::normalizeTransforms($transforms);

    if (count($transforms) === 0) {
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


  // Static methods
  // --------------

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
   * @param array $definition
   * @return array
   */
  static public function extractTransforms(array $definition): array {
    return [];
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
   * @param mixed $config
   * @param mixed $parent
   * @param string|string[] $attributeKeys
   * @return array
   */
  static public function mergeAttributes(array $config, array $parent, $attributeKeys = ['attributes']) {
    if (!is_array($attributeKeys)) {
      $attributeKeys = [$attributeKeys];
    }

    foreach ($attributeKeys as $attributeKey) {
      $hasTarget = array_key_exists($attributeKey, $config);
      $hasSource = array_key_exists($attributeKey, $parent);

      if ($hasTarget && $hasSource) {
        $config[$attributeKey] = array_merge(
          $parent[$attributeKey],
          self::mergeClassNames($config[$attributeKey], $parent[$attributeKey])
        );
      } elseif ($hasSource) {
        $config[$attributeKey] = $parent[$attributeKey];
      }
    }

    return $config;
  }

  /**
   * @param array $config
   * @param array $parent
   * @return array
   */
  static public function mergeConfig(array $config, array $parent) {
    return array_merge($parent, $config);
  }

  /**
   * @param array $config
   * @param array $parent
   * @param string $key
   * @return array
   */
  static public function mergeClassNames(array $config, array $parent, $key = 'class') {
    if (
      array_key_exists($key, $config) &&
      array_key_exists($key, $parent)
    ) {
      if ($config[$key]{0} == '=') {
        $config[$key] = substr($config[$key], 1);
      } else {
        $config[$key] = implode(' ', array_unique(array_merge(
          explode(' ', $parent[$key]),
          explode(' ', $config[$key])
        )));
      }
    }

    return array_merge($parent, $config);
  }

  /**
   * @param mixed $transforms
   * @return array
   */
  static public function normalizeTransforms($transforms) {
    if (is_string($transforms)) {
      $transforms = explode(',', $transforms);
    }

    if (!is_array($transforms)) {
      $transforms = [];
    }

    return $transforms;
  }

  /**
   * @param array $sources
   * @return string
   */
  static public function toSourceSet($sources) {
    $maxSource = array_pop($sources);
    $srcSet    = [];

    foreach ($sources as $source) {
      $srcSet[] = $source['src'] . ' ' . $source['width'] . 'w';
    }

    $srcSet[] = $maxSource['src'];
    return implode(',', $srcSet);
  }
}
