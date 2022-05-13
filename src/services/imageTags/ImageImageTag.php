<?php

namespace lenz\contentfield\services\imageTags;

use craft\helpers\Html;
use lenz\contentfield\services\imageTags\scopes\AbstractScope;

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
  public string $alt = '{title}';

  /**
   * @var string
   */
  public string $class;

  /**
   * @var string
   */
  public string $height = '{height}';

  /**
   * @var string
   */
  public string $sizes;

  /**
   * @var string
   */
  public string $src = '{src}';

  /**
   * @var string
   */
  public string $width = '{width}';


  /**
   * @inheritDoc
   */
  public function render(): string {
    $sources = $this->getSources();
    $attributes = [
      'alt' => $this->alt,
      'class' => $this->class ?? '',
      'height' => $this->height,
      'sizes' => $this->sizes ?? '',
      'src' => $this->src,
      'width' => $this->width,
    ];

    if (count($sources) > 1) {
      $attributes['srcset'] = '{srcset}';
    }

    return Html::tag('img', '',
      AbstractScope::expandAttributes($sources->getVariables(), $attributes)
    );
  }
}
