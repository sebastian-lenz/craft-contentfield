<?php

namespace contentfield\services\imageTags;


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
    if (is_string($source)) {
      $source = array('transforms' => $source);
    }

    if (isset($source['transform'])) {
      $source['transforms'] = $source['transform'];
    }

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
}
