<?php

namespace contentfield\models\fields;

use contentfield\models\values\AbstractValue;
use contentfield\models\values\StringValue;
use contentfield\models\widgets\InputWidget;

/**
 * Class StringField
 */
class StringField extends AbstractField
{
  /**
   * @inheritdoc
   */
  const DEFAULT_WIDGET = InputWidget::NAME;

  /**
   * The internal name of this field.
   */
  const NAME = 'string';


  /**
   * @inheritdoc
   */
  public function createValue($data, AbstractValue $parent) {
    return new StringValue($data, $parent, $this);
  }
}
