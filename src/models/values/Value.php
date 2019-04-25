<?php

namespace sebastianlenz\contentfield\models\values;

use sebastianlenz\contentfield\models\fields\AbstractField;

/**
 * Class Value
 */
abstract class Value implements ValueInterface
{
  use ValueTrait;

  /**
   * Value constructor.
   *
   * @param ValueInterface $parent
   * @param AbstractField $field
   */
  public function __construct(ValueInterface $parent = null, AbstractField $field = null) {
    $this->_field = $field;
    $this->_parent = $parent;
  }
}
