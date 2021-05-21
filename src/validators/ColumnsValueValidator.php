<?php

namespace lenz\contentfield\validators;

use lenz\contentfield\models\values\LayoutValue;
use yii\base\Model;

/**
 * Class ColumnsValueValidator
 */
class ColumnsValueValidator extends ValueValidator
{
  /**
   * @param mixed $value
   * @return array|null
   */
  protected function validateValue($value): ?array {
    if (!($value instanceof LayoutValue)) {
      return ['The value must be an instance of lenz\contentfield\models\values\ColumnsValue.', []];
    }

    foreach ($value->getColumns() as $index => $column) {
      $columnValue = $column->getValue();

      if ($columnValue instanceof Model && !$columnValue->validate()) {
        return ['The column {index} contains errors: {errors}', [
          'index' => $index,
          'errors' => implode(' ', $columnValue->getErrorSummary(false)),
        ]];
      }
    }

    return null;
  }
}
