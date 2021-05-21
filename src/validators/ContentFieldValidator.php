<?php

namespace lenz\contentfield\validators;

use lenz\contentfield\models\Content;
use yii\validators\Validator;

/**
 * Class ContentFieldValidator
 */
class ContentFieldValidator extends Validator
{
  /**
   * @param mixed $value
   * @return array|null
   */
  protected function validateValue($value): ?array {
    if (!($value instanceof Content)) {
      return ['The value must be an instance of lenz\contentfield\models\Content.', []];
    }

    $model = $value->getModel();
    if (is_null($model)) {
      return null;
    }

    $model->validate();
    return $model->hasErrors()
      ? ['The field contains errors', []]
      : null;
  }
}
