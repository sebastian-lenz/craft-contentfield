<?php

namespace lenz\contentfield\helpers;

use lenz\contentfield\models\values\InstanceValue;

/**
 * Interface InstanceAwareInterface
 */
interface InstanceAwareInterface
{
  /**
   * @param InstanceValue $instance
   * @return void
   */
  public function setInstance(InstanceValue $instance);
}
