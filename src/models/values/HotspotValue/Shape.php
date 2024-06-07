<?php

namespace lenz\contentfield\models\values\HotspotValue;

use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

/**
 * Class Shape
 */
abstract class Shape extends BaseObject implements \JsonSerializable
{
  /**
   * @var string
   */
  public string $uuid;


  // Static methods
  // --------------

  /**
   * @param array $config
   * @return Shape|null
   */
  static public function tryCreate(array $config): ?Shape {
    return match(ArrayHelper::remove($config, 'type')) {
      'point' => new PointShape($config),
      'rectangle' => new RectangleShape($config),
      default => null,
    };
  }
}
