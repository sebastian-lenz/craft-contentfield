<?php

namespace lenz\contentfield\events;

use yii\base\Event;

/**
 * Class RenderEvent
 */
class RenderEvent extends Event
{
  /**
   * @var \lenz\contentfield\models\Content
   */
  public $content;
}
