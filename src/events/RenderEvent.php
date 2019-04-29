<?php

namespace lenz\contentfield\events;

use lenz\contentfield\models\Content;
use yii\base\Event;

/**
 * Class RenderEvent
 */
class RenderEvent extends Event
{
  /**
   * @var Content
   */
  public $content;
}
