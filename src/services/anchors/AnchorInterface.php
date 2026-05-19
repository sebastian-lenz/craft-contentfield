<?php

namespace lenz\contentfield\services\anchors;

/**
 * Interface AnchorInterface
 */
interface AnchorInterface
{
  /**
   * @return string
   */
  public function getId(): string;

  /**
   * @return string
   */
  public function getTitle(): string;

  /**
   * @param string $value
   * @return void
   */
  public function setId(string $value): void;
}
