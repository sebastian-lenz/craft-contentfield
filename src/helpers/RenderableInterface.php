<?php

namespace lenz\contentfield\helpers;

/**
 * Interface RenderableInterface
 */
interface RenderableInterface
{
  /**
   * Returns the rendered result of this element.
   *
   * @param array $variables
   * @param array $options
   * @return string
   */
  public function render(array $variables = [], array $options = []): string;
}
