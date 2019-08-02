<?php

namespace lenz\contentfield\models\values;

use lenz\contentfield\models\fields\AbstractEnumerationField;

/**
 * Class EnumerationValue
 *
 * @property AbstractEnumerationField $_field
 */
class EnumerationValue extends Value
{
  /**
   * @var string|number
   */
  private $_value;


  /**
   * EnumValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface|null $parent
   * @param AbstractEnumerationField|null $field
   */
  public function __construct($data, ValueInterface $parent = null, AbstractEnumerationField $field = null) {
    parent::__construct($parent, $field);

    $this->_value = self::isValidEnumerationKey($data) ? $data : '';
  }

  /**
   * @param string $name
   * @return mixed
   */
  public function __call($name, $args) {
    return $this->getCustomData($name);
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
    return (string)$this->_value;
  }

  /**
   * @param string|number $value
   * @return bool
   */
  public function contains($value) {
    return $this->_value == $value;
  }

  /**
   * @param string $name
   * @return mixed
   */
  public function getCustomData($name) {
    $enumeration = $this->_field->getEnumeration();
    return $enumeration->getCustomData($this->_value, $name);
  }

  /**
   * @return number|string
   */
  public function getValue() {
    return $this->_value;
  }

  /**
   * @inheritDoc
   */
  public function isEmpty() {
    return empty($this->_value);
  }


  // Static methods
  // --------------

  /**
   * @param mixed $value
   * @return bool
   */
  static public function isValidEnumerationKey($value) {
    return is_int($value) || is_string($value);
  }
}
