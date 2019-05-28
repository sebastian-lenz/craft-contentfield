<?php

namespace lenz\contentfield\models\values;

use lenz\contentfield\models\fields\enumerations\AbstractEnumerationField;

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
   * @param ValueInterface $parent
   * @param AbstractEnumerationField $field
   */
  public function __construct($data, ValueInterface $parent, AbstractEnumerationField $field) {
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
   * @param string $name
   * @return mixed
   */
  public function getCustomData($name) {
    $enumeration = $this->_field->getEnumeration();
    return $enumeration->getCustomData($this->_value, $name);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData() {
    return $this->_value;
  }

  /**
   * @return number|string
   */
  public function getValue() {
    return $this->_value;
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return empty($this->_value);
  }

  /**
   * @param mixed $value
   * @return bool
   */
  static function isValidEnumerationKey($value) {
    return is_int($value) || is_string($value);
  }
}
