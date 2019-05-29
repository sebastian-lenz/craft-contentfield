<?php

namespace lenz\contentfield\events;

use yii\base\ActionEvent;
use yii\base\Event;

/**
 * Class BeforeActionEvent
 */
class BeforeActionEvent extends Event
{
  /**
   * @var ActionEvent
   */
  public $originalEvent;

  /**
   * @var string|null
   */
  public $requestedUuid;
}
