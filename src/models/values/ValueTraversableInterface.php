<?php

namespace lenz\contentfield\models\values;

/**
 * Interface ValueTraversableInterface
 */
interface ValueTraversableInterface
{
  /**
   * @param string|string[] $qualifier
   * @return InstanceValue[]
   */
  public function findInstances($qualifier);

  /**
   * @param string $uuid
   * @return InstanceValue|null
   */
  public function findUuid(string $uuid);
}
