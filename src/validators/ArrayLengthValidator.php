<?php

namespace lenz\contentfield\validators;

use yii\validators\Validator;

/**
 * Class ArrayLengthValidator
 */
class ArrayLengthValidator extends ValueValidator
{
  /**
   * @var int|null
   */
  public int|null $max = null;

  /**
   * @var int|null
   */
  public int|null $min = null;


  /**
   * @param mixed $value
   * @return array|null
   */
  protected function validateValue($value): ?array {
    if (!is_countable($value)) {
      return ['The value must be countable.', []];
    }

    if (!is_null($this->max) && count($value) > $this->max) {
      return ["A maximum of $this->max items is allowed.", []];
    }

    if (!is_null($this->min) && count($value) < $this->min) {
      if ($this->min == 1) {
        return ["At least one entry is required.", []];
      } else {
        return ["At least $this->min entries are required.", []];
      }
    }

    return null;
  }
}
