<?php

namespace lenz\contentfield\validators;

use lenz\contentfield\models\values\ArrayValue;
use lenz\contentfield\models\values\InstanceValue;

/**
 * Class ArrayValueValidator
 */
class ArrayValueValidator extends ValueValidator
{
  /**
   * @param mixed $value
   * @return array|null
   */
  protected function validateValue($value): ?array {
    if (!($value instanceof ArrayValue)) {
      return ['The value must be an instance of lenz\contentfield\models\values\ArrayValue.', []];
    }

    $hasErrors = false;
    foreach ($value as $item) {
      if ($item instanceof InstanceValue && !$item->validate()) {
        $hasErrors = true;
      }
    }

    return $hasErrors
      ? ['One or more values contain errors.', []]
      : null;
  }
}
