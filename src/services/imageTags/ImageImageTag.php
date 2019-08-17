<?php

namespace lenz\contentfield\services\imageTags;

use craft\elements\Asset;
use craft\helpers\Html;
use lenz\contentfield\services\imageTags\scopes\AbstractScope;
use lenz\contentfield\services\imageTags\sources\SourceSet;

/**
 * Class ImageImageTag
 *
 * Renders a basic <img /> tag.
 */
class ImageImageTag extends AbstractImageTag
{
  /**
   * @var string
   */
  public $alt = '{title}';

  /**
   * @var string
   */
  public $class;

  /**
   * @var string
   */
  public $height = '{height}';

  /**
   * @var string
   */
  public $sizes;

  /**
   * @var string
   */
  public $src = '{src}';

  /**
   * @var string
   */
  public $width = '{width}';


  /**
   * @inheritDoc
   */
  public function render(): string {
    $sources = $this->getSources();
    $attributes = [
      'alt'    => $this->alt,
      'class'  => isset($this->class) ? $this->class : '',
      'height' => $this->height,
      'sizes'  => isset($this->sizes) ? $this->sizes : '',
      'src'    => $this->src,
      'width'  => $this->width,
    ];

    if (count($sources) > 1) {
      $attributes['srcset'] = '{srcset}';
    }

    return Html::tag('img', '',
      AbstractScope::expandAttributes($sources->getVariables(), $attributes)
    );
  }
}
