<?php

namespace lenz\contentfield\services\imageTags\sources;

use craft\elements\Asset;
use craft\models\ImageTransform;
use lenz\craft\utils\helpers\ImageTransforms;
use Throwable;
use yii\base\InvalidConfigException;
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
  private Asset $_asset;

  /**
   * @var string
   */
  private string $_descriptor;

  /**
   * @var int|null
   */
  private ?int $_height;

  /**
   * @var ImageTransform|string|array|null
   */
  private ImageTransform|string|array|null $_transform;

  /**
   * @var string|null
   */
  private ?string $_url;

  /**
   * @var int|null
   */
  private ?int $_width;


  /**
   * Source constructor.
   *
   * @param Asset $asset
   * @param array|string|ImageTransform|null $transform
   */
  public function __construct(Asset $asset, ImageTransform|array|string $transform = null) {
    $this->_asset = $asset;
    $this->_transform = $transform;
  }

  /**
   * @return float
   */
  public function getAspect(): float {
    return $this->getHeight() / $this->getWidth();
  }

  /**
   * @return string
   */
  public function getAspectPercent(): string {
    return round($this->getAspect() * 100, 6) . '%';
  }

  /**
   * @return Asset
   */
  public function getAsset(): Asset {
    return $this->_asset;
  }

  /**
   * @return string|null
   */
  public function getBase64(): ?string {
    $asset = $this->_asset;

    try {
      $transformer = ImageTransforms::getTransformer();
      $transform = $transformer->getTransformIndex($asset, $this->_transform);
      if (!$transform->fileExists) {
        ImageTransforms::ensureTransformUrlByIndexModel($asset, $transform);
      }

      $fileName = ImageTransforms::getTransformPath($asset, $transform);
      $stream = $asset->getVolume()->getFs()->getFileStream($fileName);
      $mimeType = FileHelper::getMimeTypeByExtension($fileName);
      $encoded = base64_encode(stream_get_contents($stream));

      return "url('data:" . $mimeType. ";base64," . $encoded . "')";
    } catch (Throwable) {
      // Ignore
    }

    return null;
  }

  /**
   * @return string
   */
  public function getCssAspect(): string {
    return 'padding-bottom:' . $this->getAspectPercent() . ';';
  }

  /**
   * @return string
   */
  public function getCssBackground(): string {
    $base64 = $this->getBase64();

    return is_null($base64)
      ? ''
      : 'background-image:' . $base64 . ';';
  }

  /**
   * @return string
   */
  public function getDescriptor(): string {
    if (!isset($this->_descriptor)) {
      $this->_descriptor = $this->getWidth() . 'w';
    }

    return $this->_descriptor;
  }

  /**
   * @return float
   */
  public function getFocusX(): float {
    $focalPoint = $this->_asset->getFocalPoint();
    return is_array($focalPoint)
      ? $focalPoint['x']
      : 0.5;
  }

  /**
   * @return string
   */
  public function getFocusXPercent(): string {
    return round($this->getFocusX() * 100, 6) . '%';
  }

  /**
   * @return float
   */
  public function getFocusY(): float {
    $focalPoint = $this->_asset->getFocalPoint();
    return is_array($focalPoint)
      ? $focalPoint['y']
      : 0.5;
  }

  /**
   * @return string
   */
  public function getFocusYPercent(): string {
    return round($this->getFocusY() * 100, 6) . '%';
  }

  /**
   * @return int|null
   */
  public function getHeight(): int|null {
    if (!isset($this->_height)) {
      $this->_height = $this->_asset->getHeight($this->_transform);
    }

    return $this->_height;
  }

  /**
   * @return callable[]
   */
  public function getNativeVariables(): array {
    $fields = [];
    $layout = $this->_asset->getFieldLayout();

    if (!is_null($layout)) {
      foreach ($layout->getCustomFields() as $field) {
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
   * @throws InvalidConfigException
   */
  public function getSrc(): ?string {
    if (!isset($this->_url)) {
      $this->_url = $this->_asset->getUrl($this->_transform);
    }

    return $this->_url;
  }

  /**
   * @return string|null
   */
  public function getTitle(): ?string {
    return $this->_asset->title;
  }

  /**
   * @param string|null $prefix
   * @return callable[]
   */
  public function getVariables(string $prefix = null): array {
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
   * @return int|null
   */
  public function getWidth(): int|null {
    if (!isset($this->_width)) {
      $this->_width = $this->_asset->getWidth($this->_transform);
    }

    return $this->_width;
  }

  /**
   * @param string $value
   */
  public function setDescriptor(string $value): void {
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
