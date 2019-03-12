<?php

namespace sebastianlenz\contentfield\events;

use craft\base\ElementInterface;
use yii\base\Event;

/**
 * Class RootSchemasEvent
 */
class RootSchemasEvent extends Event
{
  /**
   * @var ElementInterface
   */
  public $element;

  /**
   * @var string[]
   */
  public $schemas;
}
