<?php

namespace lenz\contentfield\validators;

use lenz\contentfield\models\fields\AbstractField;
use yii\validators\Validator;

/**
 * Class FieldValidator
 */
class FieldValidator extends Validator
{
  /**
   * @inheritDoc
   */
  protected function validateValue($value) {
    if (!($value instanceof AbstractField)) {
      return ['Must be an instances of `lenz\contentfield\models\fields\AbstractField`.', []];
    }

    if (!$value->validate()) {
      $errors = implode(' ', $value->getErrorSummary(false));
      return ['The field configuration contains errors: ' . $errors, []];
    }

    return null;
  }
}
