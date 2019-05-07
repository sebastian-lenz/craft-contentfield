<?php

namespace lenz\contentfield\utilities\twig;

/**
 * Interface DisplayInterface
 */
interface DisplayInterface
{
  /**
   * @param array $variables
   * @return void
   */
  public function display(array $variables = []);
}
