<?php

namespace lenz\contentfield\services\imageTags;

use craft\helpers\Html;

/**
 * Class WrappedImageTag
 */
class WrappedImageTag extends DefaultImageTag
{
  /**
   * @var bool|array
   */
  public $noscript = false;

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
  public $wrapAttributes = array();

  /**
   * @var string
   */
  public $wrapTag = 'div';

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

    if ($this->noscript) {
      $content .= Html::tag(
        'noscript',
        Html::tag('img', '', $this->expandAttributes(
          is_array($this->noscript) ? $this->noscript : self::DEFAULT_NOSCRIPT,
          $values
        ))
      );
    }

    return Html::tag(
      $this->wrapTag,
      $content,
      $this->expandAttributes(
        $this->wrapAttributes,
        $values
      )
    );
  }


  // Static methods
  // --------------

  /**
   * @param array $config
   * @param array $parent
   * @return array
   */
  static public function mergeConfig(array $config, array $parent) {
    return array_merge(
      $parent,
      self::mergeAttributes($config, $parent, [
        'attributes', 'placeholderAttributes', 'wrapAttributes'
      ])
    );
  }
}
