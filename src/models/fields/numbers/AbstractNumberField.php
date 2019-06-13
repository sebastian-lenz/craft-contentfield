<?php

namespace lenz\contentfield\models\fields\booleans;

use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\values\ValueInterface;

/**
 * Class AbstractNumberField
 */
abstract class AbstractNumberField extends AbstractField
{
  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent) {
    return is_numeric($data) ? $data * 1 : null;
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue($value) {
    return is_numeric($value) ? $value * 1 : null;
  }
}
