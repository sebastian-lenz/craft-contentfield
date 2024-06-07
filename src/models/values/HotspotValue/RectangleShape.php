<?php

namespace lenz\contentfield\models\values\HotspotValue;

/**
 * Class RectangleShape
 */
class RectangleShape extends Shape
{
  /**
   * @var float
   */
  public float $height = 0;

  /**
   * @var float
   */
  public float $width = 0;

  /**
   * @var float
   */
  public float $x = 0;

  /**
   * @var float
   */
  public float $y = 0;


  /**
   * @inheritDoc
   */
  public function jsonSerialize(): array {
    return [
      'height' => $this->height,
      'type' => 'rectangle',
      'uuid' => $this->uuid,
      'width' => $this->width,
      'x' => $this->x,
      'y' => $this->y,
    ];
  }
}
