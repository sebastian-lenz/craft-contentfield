<?php

namespace lenz\contentfield\events;

use lenz\contentfield\models\values\InstanceValue;
use yii\base\Event;

/**
 * Class InstanceSearchKeywordsEvent
 */
class InstanceSearchKeywordsEvent extends Event
{
  /** @var InstanceValue */
  public InstanceValue $instance;

  /** @var string[] */
  public array $keywords;
}
