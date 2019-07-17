<?php

namespace lenz\contentfield\models\fields;

use lenz\contentfield\models\values\ValueInterface;

/**
 * Class AbstractNumberField
 */
abstract class AbstractNumberField extends AbstractField
{
  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent = null) {
    return is_numeric($data) ? $data * 1 : null;
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue($value) {
    return is_numeric($value) ? $value * 1 : null;
  }
}
