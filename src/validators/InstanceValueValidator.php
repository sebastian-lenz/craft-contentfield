<?php

namespace lenz\contentfield\validators;

use lenz\contentfield\models\values\InstanceValue;

/**
 * Class InstanceValueValidator
 */
class InstanceValueValidator extends ValueValidator
{
  /**
   * @param mixed $value
   * @return array|null
   */
  protected function validateValue($value): ?array {
    if (!($value instanceof InstanceValue)) {
      return ['The value must be an instance of lenz\contentfield\models\values\InstanceValue.', []];
    }

    if ($value->validate()) {
      return null;
    }

    return ['One or more attributes are invalid.', []];
  }
}
