<?php

namespace lenz\contentfield\services\imageTags;

use craft\helpers\Html;
use craft\helpers\Image;

/**
 * Class DefaultImageTag
 */
class DefaultImageTag extends ImageTag
{
  /**
   * @var array
   */
  public $attributes = array(
    'width'  => '$width',
    'height' => '$height',
    'alt'    => '$title',
  );

  /**
   * @var string
   */
  public $srcAttribute = 'src';

  /**
   * @var string
   */
  public $srcsetAttribute = 'srcset';

  /**
   * @var string[]
   */
  public $transforms;

  /**
   * @var array
   */
  private $sources;

  /**
   * List of attributes known to contain transform names.
   */
  const TRANSFORM_ATTRIBUTES = [
    'fallbackTransform',
    'thumbnailTransform',
    'transforms'
  ];


  /**
   * @inheritdoc
   */
  public function __construct(array $config = []) {
    if (isset($config['transform'])) {
      $config['transforms'] = $config['transform'];
      unset($config['transform']);
    }

    if (isset($config['transforms']) && !is_array($config['transforms'])) {
      $config['transforms'] = explode(',', (string)$config['transforms']);
    }

    parent::__construct($config);
  }

  /**
   * @return array
   */
  public function getMaxSource() {
    $sources = $this->getSources();
    return $sources[count($sources) - 1];
  }

  /**
   * @return array
   */
  public function getSources() {
    if (!isset($this->sources)) {
      $this->sources = $this->toSources($this->transforms);
    }

    return $this->sources;
  }

  /**
   * @return string
   */
  public function getSourceSet() {
    return self::toSourceSet($this->getSources());
  }

  /**
   * @inheritdoc
   */
  public function isSupported() {
    $ext = $this->asset->getExtension();
    return Image::canManipulateAsImage($ext);
  }

  /**
   * @inheritDoc
   */
  public function render() {
    $sources = $this->getSources();
    $maxSource = array_pop($sources);

    $attributes = $this->expandAttributes(
      self::ensureSourceAttribute(
        $this->attributes,
        count($sources) > 0
      ),
      array(
        '$height' => $maxSource['height'],
        '$src'    => $maxSource['src'],
        '$width'  => $maxSource['width'],
        '$srcset' => array($this, 'getSourceSet'),
      )
    );

    return Html::tag('img', '', $attributes);
  }


  // Static methods
  // --------------

  /**
   * @param array $definition
   * @return array
   */
  static public function extractTransforms(array $definition): array {
    $transforms = array();

    foreach (self::TRANSFORM_ATTRIBUTES as $attribute) {
      if (!array_key_exists($attribute, $definition)) {
        continue;
      }

      $transforms = array_merge(
        $transforms,
        self::normalizeTransforms($definition[$attribute])
      );
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
        'attributes',
      ])
    );
  }
}
