<?php

namespace lenz\contentfield\services\imageTags;

use craft\helpers\Html;
use craft\helpers\Image;

/**
 * Class PictureImageTag
 */
class PictureImageTag extends ImageTag
{
  /**
   * @var array|boolean
   */
  public $attributes = true;

  /**
   * @var boolean|array
   */
  public $noscript = false;

  /**
   * @var array
   */
  public $pictureAttributes = [];

  /**
   * @var string
   */
  public $placeholder = '';

  /**
   * @var array
   */
  public $placeholderAttributes = array();

  /**
   * @var string
   */
  public $placeholderTag;

  /**
   * @var array
   */
  public $sourceAttributes = [];

  /**
   * @var array
   */
  public $sources = [];

  /**
   * The default image tag attributes.
   */
  const DEFAULT_IMAGE = [
    'height' => '$height',
    'src'    => '$src',
    'alt'    => '$title',
    'width'  => '$width',
  ];

  /**
   * The default image tag attributes for the noscript image tag.
   */
  const DEFAULT_NOSCRIPT = [
    'height' => '$height',
    'src'    => '$src',
    'alt'    => '$title',
    'width'  => '$width',
  ];


  /**
   * @inheritdoc
   */
  public function __construct(array $config = []) {
    parent::__construct($config);
  }

  /**
   * @inheritdoc
   */
  public function isSupported() {
    $ext = $this->asset->getExtension();
    return Image::canManipulateAsImage($ext);
  }

  /**
   * @inheritdoc
   */
  public function render() {
    $content = array();
    $values  = [
      '$height' => [$this, 'getMaxHeight'],
      '$src'    => [$this, 'getMaxSrc'],
      '$width'  => [$this, 'getMaxWidth'],
    ];

    foreach ($this->sources as $source) {
      $sourceTag = $this->renderSource($source);
      if (!is_null($sourceTag)) {
        $content[] = $sourceTag;
      }
    }

    if ($this->attributes) {
      $attributes = is_array($this->attributes)
        ? self::ensureSourceAttribute($this->attributes, false)
        : self::DEFAULT_IMAGE;

      $content[] = Html::tag('img', '', $this->expandAttributes($attributes, $values));
    }

    if (isset($this->placeholderTag)) {
      $content[] = Html::tag(
        $this->placeholderTag,
        $this->placeholder,
        $this->expandAttributes($this->placeholderAttributes)
      );
    }

    if ($this->noscript) {
      $content[] = Html::tag('noscript',
        Html::tag('img', '', $this->expandAttributes(
          is_array($this->noscript) ? $this->noscript : self::DEFAULT_NOSCRIPT,
          $values
        ))
      );
    }

    return Html::tag(
      'picture',
      implode('', $content),
      $this->expandAttributes($this->pictureAttributes)
    );
  }

  /**
   * @param array|string $source
   * @return string|null
   */
  public function renderSource($source) {
    $source = self::normalizeSource($source);

    if (isset($source['attributes'])) {
      $attributes = self::mergeAttributes(
        $source['attributes'],
        $this->sourceAttributes
      );
    } else {
      $attributes = $this->sourceAttributes;
    }

    $sources    = $this->toSources($source['transforms']);
    $maxSource  = $sources[count($sources) - 1];
    $attributes = $this->expandAttributes(
      self::ensureSourceAttribute($attributes, true),
      array(
        '$height' => $maxSource['height'],
        '$width'  => $maxSource['width'],
        '$srcset' => self::toSourceSet($sources),
      )
    );

    return Html::tag('source', '', $attributes);
  }

  /**
   * @return float|int|null
   */
  public function getMaxHeight() {
    return $this->asset->getHeight($this->getMaxTransform());
  }

  /**
   * @return string|null
   */
  public function getMaxSrc() {
    return $this->asset->getUrl($this->getMaxTransform());
  }

  /**
   * @return array|string
   */
  public function getMaxTransform() {
    $source = self::normalizeSource(end($this->sources));
    return end($source['transforms']);
  }

  /**
   * @return float|int|null
   */
  public function getMaxWidth() {
    return $this->asset->getWidth($this->getMaxTransform());
  }

  /**
   * @return float|int|null
   */
  public function getMinHeight() {
    return $this->asset->getHeight($this->getMinTransform());
  }

  /**
   * @return string|null
   */
  public function getMinSrc() {
    return $this->asset->getUrl($this->getMinTransform());
  }

  /**
   * @return array|string
   */
  public function getMinTransform() {
    $source = self::normalizeSource(reset($this->sources));
    return reset($source['transforms']);
  }

  /**
   * @return float|int|null
   */
  public function getMinWidth() {
    return $this->asset->getWidth($this->getMinTransform());
  }


  // Protected methods
  // -----------------

  /**
   * @param array $attributes
   * @param array $values
   * @return array
   */
  protected function expandAttributes($attributes, $values = array()) {
    return parent::expandAttributes($attributes, $values + array(
      '$maxHeight' => [$this, 'getMaxHeight'],
      '$maxSrc'    => [$this, 'getMaxSrc'],
      '$maxWidth'  => [$this, 'getMaxWidth'],
      '$minHeight' => [$this, 'getMinHeight'],
      '$minSrc'    => [$this, 'getMinSrc'],
      '$minWidth'  => [$this, 'getMinWidth'],
    ));
  }


  // Static methods
  // --------------

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
   * @param array $config
   * @param array $parent
   * @return array
   */
  static public function mergeConfig(array $config, array $parent) {
    return array_merge(
      $parent,
      self::mergeAttributes($config, $parent, [
        'attributes', 'pictureAttributes', 'placeholderAttributes', 'sourceAttributes'
      ])
    );
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
      $source['transforms'] = [$source['transform']];
    } elseif (!isset($source['transforms'])) {
      $source['transforms'] = [null];
    }

    return $source;
  }
}
