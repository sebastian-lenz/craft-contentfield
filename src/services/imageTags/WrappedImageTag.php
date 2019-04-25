<?php

namespace lenz\contentfield\services\imageTags;

use craft\helpers\Html;

/**
 * Class WrappedImageTag
 */
class WrappedImageTag extends DefaultImageTag
{
  /**
   * @var bool
   */
  public $withNoscript = true;

  /**
   * @var bool
   */
  public $withRatio = true;

  /**
   * @var array
   */
  public $wrapAttributes = array();

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
   * @return string
   */
  public function getAspectStyle() {
    $source = $this->getMaxSource();
    $ratio = round($source['height'] / $source['width'] * 100, 6);
    return 'padding-bottom:' . $ratio . '%;';
  }

  /**
   * @return string
   */
  public function render() {
    $content = parent::render();
    $source = $this->getMaxSource();
    $values = array(
      '$height'      => $source['height'],
      '$src'         => $source['src'],
      '$width'       => $source['width'],
      '$srcset'      => array($this, 'getSourceSet'),
      '$aspectStyle' => array($this, 'getAspectStyle'),
    );

    if (isset($this->placeholderTag)) {
      $content = Html::tag(
        $this->placeholderTag,
        $this->placeholder,
        $this->expandAttributes(
          $this->placeholderAttributes,
          $values
        )
      ) . $content;
    }

    if ($this->withNoscript) {
      $content .= Html::tag(
        'noscript',
        Html::tag('img', '', $source + array(
          'alt' => $this->asset->title
        ))
      );
    }

    return Html::tag(
      'div',
      $content, $this->expandAttributes(
        $this->wrapAttributes,
        $values
      )
    );
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
}
