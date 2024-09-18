<?php

namespace lenz\contentfield\twig;

use Generator;

/**
 * Interface DisplayInterface
 */
interface DisplayInterface
{
  /**
   * @param array $variables
   * @return Generator
   */
  public function display(array $variables = []): Generator;
}
