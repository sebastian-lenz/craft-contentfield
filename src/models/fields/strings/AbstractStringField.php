<?php

namespace contentfield\models\fields\strings;

use contentfield\models\fields\AbstractField;
use contentfield\models\values\AbstractValue;
use contentfield\models\values\StringValue;

/**
 * Class StringField
 */
abstract class AbstractStringField extends AbstractField
{
  /**
   * @inheritdoc
   */
  public function createValue($data, AbstractValue $parent) {
    return new StringValue($data, $parent, $this);
  }
}
