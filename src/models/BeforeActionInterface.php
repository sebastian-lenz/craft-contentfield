<?php

namespace lenz\contentfield\models;

use lenz\contentfield\events\BeforeActionEvent;

/**
 * Interface BeforeActionInterface
 */
interface BeforeActionInterface
{
  /**
   * @param BeforeActionEvent $event
   * @return void
   */
  public function onBeforeAction(BeforeActionEvent $event);
}
