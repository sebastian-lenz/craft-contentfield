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
   * @return array
   */
  public function getMaxSource() {
    $sources = $this->getSources();
    return $sources[count($sources) - 1];
  }

  /**
   * @inheritdoc
   */
  public function isSupported() {
    $ext = $this->asset->getExtension();
    return Image::canManipulateAsImage($ext);
  }

  /**
   * @return string
   */
  function render() {
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

  /**
   * @param array $target
   * @param array $source
   * @return array
   */
  static public function mergeConfig($target, $source) {
    return self::mergeAttributes($target, $source) + $source;
  }
}
