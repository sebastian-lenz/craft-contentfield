<?php

namespace lenz\contentfield\models\values\HotspotValue;

/**
 * Class PointShape
 */
class PointShape extends Shape
{
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
      'type' => 'point',
      'uuid' => $this->uuid,
      'x' => $this->x,
      'y' => $this->y,
    ];
  }
}
