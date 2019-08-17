<?php

namespace lenz\contentfield\services\imageTags\sources;

use Craft;
use craft\elements\Asset;
use craft\models\AssetTransform;
use Throwable;
use yii\helpers\FileHelper;

/**
 * Class Source
 *
 * Represents a single asset source. A source stores an asset with
 * a transform and exposes utility functions.
 */
class Source
{
  /**
   * @var Asset
   */
  private $_asset;

  /**
   * @var string
   */
  private $_descriptor;

  /**
   * @var int|float|null
   */
  private $_height;

  /**
   * @var AssetTransform|string|array|null
   */
  private $_transform = null;

  /**
   * @var string|null
   */
  private $_url;

  /**
   * @var int|float|null
   */
  private $_width;


  /**
   * Source constructor.
   *
   * @param Asset $asset
   * @param AssetTransform|array|string|null $transform
   */
  public function __construct(Asset $asset, $transform = null) {
    $this->_asset = $asset;
    $this->_transform = $transform;
  }

  /**
   * @return float
   */
  public function getAspect() {
    return $this->getHeight() / $this->getWidth();
  }

  /**
   * @return string
   */
  public function getAspectPercent() {
    return round($this->getAspect() * 100, 6) . '%';
  }

  /**
   * @return Asset
   */
  public function getAsset() {
    return $this->_asset;
  }

  /**
   * @return string|null
   */
  public function getBase64() {
    $asset      = $this->_asset;
    $volume     = $asset->volume;
    $transforms = Craft::$app->getAssetTransforms();
    $transform  = null;

    try {
      $transform = $transforms->getTransformIndex($asset, $this->_transform);
      if (!$transform->fileExists) {
        $transforms->ensureTransformUrlByIndexModel($transform);
      }

      $fileName = implode('', [
        $asset->folderPath,
        $transforms->getTransformSubpath($asset, $transform)
      ]);

      $stream   = $volume->getFileStream($fileName);
      $mimeType = FileHelper::getMimeTypeByExtension($fileName);
      $encoded  = base64_encode(stream_get_contents($stream));

      return "url('data:" . $mimeType. ";base64," . $encoded . "')";
    } catch (Throwable $exception) {
      if (
        !is_null($transform) &&
        !is_null($transform->id)
      ) {
        $transforms->deleteTransformIndex($transform->id);
      }
    }

    return null;
  }

  /**
   * @return string
   */
  public function getCssAspect() {
    return 'padding-bottom:' . $this->getAspectPercent() . ';';
  }

  /**
   * @return string
   */
  public function getCssBackground() {
    $base64 = $this->getBase64();

    return is_null($base64)
      ? ''
      : 'background-image:' . $base64 . ';';
  }

  /**
   * @return string
   */
  public function getDescriptor() {
    if (!isset($this->_descriptor)) {
      $this->_descriptor = $this->getWidth() . 'w';
    }

    return $this->_descriptor;
  }

  /**
   * @return float
   */
  public function getFocusX() {
    $focalPoint = $this->_asset->getFocalPoint();
    return is_array($focalPoint)
      ? $focalPoint['x']
      : 0.5;
  }

  /**
   * @return string
   */
  public function getFocusXPercent() {
    return round($this->getFocusX() * 100, 6) . '%';
  }

  /**
   * @return float
   */
  public function getFocusY() {
    $focalPoint = $this->_asset->getFocalPoint();
    return is_array($focalPoint)
      ? $focalPoint['y']
      : 0.5;
  }

  /**
   * @return string
   */
  public function getFocusYPercent() {
    return round($this->getFocusY() * 100, 6) . '%';
  }

  /**
   * @return float|int|null
   */
  public function getHeight() {
    if (!isset($this->_height)) {
      $this->_height = $this->_asset->getHeight($this->_transform);
    }

    return $this->_height;
  }

  /**
   * @return callable[]
   */
  public function getNativeVariables() {
    $fields = [];
    $layout = $this->_asset->getFieldLayout();

    if (!is_null($layout)) {
      foreach ($layout->getFields() as $field) {
        $handle = $field->handle;
        $fields[$handle] = function() use ($handle) {
          return $this->_asset->getFieldValue($handle);
        };
      }
    }

    $variables = [
      'focusX'        => [$this, 'getFocusX'],
      'focusXPercent' => [$this, 'getFocusXPercent'],
      'focusY'        => [$this, 'getFocusY'],
      'focusYPercent' => [$this, 'getFocusYPercent'],
      'title'         => [$this, 'getTitle'],
    ];

    return array_merge(
      $fields,
      $variables,
      $this->getVariables('native')
    );
  }

  /**
   * @return string|null
   */
  public function getSrc() {
    if (!isset($this->_url)) {
      $this->_url = $this->_asset->getUrl($this->_transform);
    }

    return $this->_url;
  }

  /**
   * @return string|null
   */
  public function getTitle() {
    return $this->_asset->title;
  }

  /**
   * @param string|null $prefix
   * @return callable[]
   */
  public function getVariables($prefix = null) {
    $variables = [
      'aspect'        => [$this, 'getAspect'],
      'aspectPercent' => [$this, 'getAspectPercent'],
      'base64'        => [$this, 'getBase64'],
      'cssAspect'     => [$this, 'getCssAspect'],
      'cssBackground' => [$this, 'getCssBackground'],
      'height'        => [$this, 'getHeight'],
      'src'           => [$this, 'getSrc'],
      'width'         => [$this, 'getWidth'],
    ];

    return is_null($prefix)
      ? $variables
      : self::prependArrayKey($variables, $prefix);
  }

  /**
   * @return float|int|null
   */
  public function getWidth() {
    if (!isset($this->_width)) {
      $this->_width = $this->_asset->getWidth($this->_transform);
    }

    return $this->_width;
  }

  /**
   * @param string $value
   */
  public function setDescriptor(string $value) {
    $this->_descriptor = $value;
  }


  // Static methods
  // --------------

  /**
   * @param array $array
   * @param string $prefix
   * @return array
   */
  static public function prependArrayKey(array $array, string $prefix): array {
    $result = [];
    foreach ($array as $key => $value) {
      $key = $prefix . ucfirst($key);
      $result[$key] = $value;
    }

    return $result;
  }
}
