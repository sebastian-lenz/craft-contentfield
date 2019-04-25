<?php

namespace lenz\contentfield\services\imageTags;


use craft\helpers\Html;
use craft\helpers\Image;

/**
 * Interface PictureImageTag
 */
class PictureImageTag extends ImageTag
{
  /**
   * @var array
   */
  public $attributes;

  /**
   * @var string|null
   */
  public $fallbackTransform = null;

  /**
   * @var string
   */
  public $placeholder = '';

  /**
   * @var string
   */
  public $placeholderTag;

  /**
   * @var array
   */
  public $placeholderAttributes = array();

  /**
   * @var array
   */
  public $sourceAttributes;

  /**
   * @var array
   */
  public $sources;

  /**
   * @var string
   */
  public $srcsetAttribute = 'srcset';


  /**
   * @inheritdoc
   */
  public function __construct(array $config = []) {
    parent::__construct($config);
  }

  /**
   * @inheritdoc
   */
  function isSupported() {
    $ext = $this->asset->getExtension();
    return Image::canManipulateAsImage($ext);
  }

  /**
   * @inheritdoc
   */
  function render() {
    $content = array();
    foreach ($this->sources as $source) {
      $sourceTag = $this->renderSource($source);
      if (!is_null($sourceTag)) {
        $content[] = $sourceTag;
      }
    }

    if (isset($this->placeholderTag)) {
      $content[] = Html::tag(
        $this->placeholderTag,
        $this->placeholder,
        $this->expandAttributes($this->placeholderAttributes)
      );
    }

    $content[] = Html::tag('noscript',
      Html::tag('img', '', array(
        'alt'    => $this->asset->title,
        'height' => $this->asset->getHeight($this->fallbackTransform),
        'src'    => $this->asset->getUrl($this->fallbackTransform),
        'width'  => $this->asset->getWidth($this->fallbackTransform),
      ))
    );

    $attributes = $this->expandAttributes($this->attributes);
    return Html::tag('picture', implode('', $content), $attributes);
  }

  /**
   * @param array|string $source
   * @return string|null
   */
  function renderSource($source) {
    $source = self::normalizeSource($source);

    if (isset($source['attributes'])) {
      $attributes = self::mergeAttributes($source['attributes'], $this->sourceAttributes);
    } else {
      $attributes = $this->sourceAttributes;
    }

    $sources = $this->toSources($source['transforms']);
    $maxSource = $sources[count($sources) - 1];
    $attributes = $this->expandAttributes(
      self::ensureSourceAttribute(
        $attributes,
        count($sources) > 1
      ),
      array(
        '$height' => $maxSource['height'],
        '$src'    => $maxSource['src'],
        '$width'  => $maxSource['width'],
        '$srcset' => self::toSourceSet($sources),
      )
    );

    return Html::tag('source', '', $attributes);
  }

  /**
   * @param array $definition
   * @return array
   */
  static public function extractTransforms(array $definition): array {
    $transforms = array();

    if (array_key_exists('sources', $definition)) {
      foreach ($definition['sources'] as $source) {
        $source = self::normalizeSource($source);
        $transforms = array_merge(
          $transforms,
          self::normalizeTransforms($source['transforms'])
        );
      }
    }

    return $transforms;
  }

  /**
   * @param array $target
   * @param array $source
   * @return array
   */
  static public function mergeConfig($target, $source) {
    return self::mergeAttributes(
      $target,
      $source,
      array('attributes', 'wrapAttributes')
    ) + $source;
  }

  /**
   * @param mixed $source
   * @return array
   */
  static public function normalizeSource($source) {
    if (is_string($source)) {
      $source = array('transforms' => $source);
    }

    if (!is_array($source)) $source = [];
    if (isset($source['transform'])) {
      $source['transforms'] = $source['transform'];
    } elseif (!isset($source['transforms'])) {
      $source['transforms'] = [];
    }

    return $source;
  }
}
