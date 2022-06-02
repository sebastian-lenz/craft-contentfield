<?php

namespace lenz\contentfield\twig;

/**
 * Interface DisplayInterface
 */
interface DisplayInterface
{
  /**
   * @param array $variables
   * @return void
   */
  public function display(array $variables = []): void;
}
