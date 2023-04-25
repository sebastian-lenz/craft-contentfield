<?php

namespace lenz\contentfield\models\enumerations;

use lenz\contentfield\models\fields\AbstractEnumerationField;

/**
 * Interface EnumerationInterface
 */
interface EnumerationInterface
{
  /**
   * @param AbstractEnumerationField|null $field
   * @param array $options
   */
  function __construct(?AbstractEnumerationField $field, array $options = []);

  /**
   * Return an array of all options.
   * @return array
   */
  function getOptions(): array;
}
