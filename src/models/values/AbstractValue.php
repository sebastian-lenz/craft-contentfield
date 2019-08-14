<?php

namespace lenz\contentfield\models\values;

use lenz\contentfield\models\fields\AbstractField;

/**
 * Class AbstractValue
 */
abstract class AbstractValue implements ValueInterface
{
  use ValueTrait;

  /**
   * Value constructor.
   *
   * @param ValueInterface|null $parent
   * @param AbstractField|null $field
   */
  public function __construct(ValueInterface $parent = null, AbstractField $field = null) {
    $this->_field = $field;
    $this->_parent = $parent;
  }
}
