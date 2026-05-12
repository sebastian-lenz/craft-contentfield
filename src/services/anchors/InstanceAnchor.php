<?php

namespace lenz\contentfield\services\anchors;

/**
 * Class InstanceAnchor
 */
class InstanceAnchor extends Anchor
{
  /**
   * @param string $uid
   * @param string $title
   */
  public function __construct(
    public readonly string $uid,
    string $title
  ) {
    parent::__construct($title);
  }
}
