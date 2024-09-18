<?php

namespace lenz\contentfield\helpers\grids;

use lenz\contentfield\models\fields\LayoutField;
use lenz\contentfield\models\values\LayoutValue;

/**
 * Interface GridInterface
 */
interface GridInterface
{
  /**
   * @param LayoutValue $layout
   * @param array $variables
   * @return \Generator
   */
  public function display(LayoutValue $layout, array $variables = []): \Generator;

  /**
   * @param LayoutField $field
   * @param string $className
   * @return array
   */
  public function parse(LayoutField $field, string $className): array;

  /**
   * @param LayoutValue $layout
   * @param array $variables
   * @param array $options
   * @return string
   */
  public function render(LayoutValue $layout, array $variables = [], array $options = []): string;
}
