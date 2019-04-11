<?php

namespace sebastianlenz\contentfield\events;

use yii\base\Event;

/**
 * Class RenderEvent
 */
class RenderEvent extends Event
{
  /**
   * @var \sebastianlenz\contentfield\models\Content
   */
  public $content;
}
