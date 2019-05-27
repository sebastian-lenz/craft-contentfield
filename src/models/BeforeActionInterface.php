<?php

namespace lenz\contentfield\models;

use yii\base\ActionEvent;

/**
 * Interface BeforeActionInterface
 */
interface BeforeActionInterface
{
  /**
   * @param ActionEvent $event
   * @return void
   */
  public function onBeforeAction(ActionEvent $event);
}
