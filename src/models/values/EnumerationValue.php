<?php

namespace contentfield\models\values;

use contentfield\models\fields\enumerations\AbstractEnumerationField;

/**
 * Class EnumerationValue
 *
 * @property AbstractEnumerationField $__field
 */
class EnumerationValue extends AbstractValue
{
  /**
   * @var string|number
   */
  private $value;


  /**
   * EnumValue constructor.
   *
   * @param mixed $data
   * @param AbstractValue $parent
   * @param AbstractEnumerationField $field
   */
  public function __construct($data, AbstractValue $parent, AbstractEnumerationField $field) {
    parent::__construct($parent, $field);
    $this->value = self::isValidEnumerationKey($data) ? $data : '';
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
    return (string)$this->value;
  }

  /**
   * @inheritdoc
   */
  public function getEditorData() {
    return $this->value;
  }

  /**
   * @inheritdoc
   */
  public function getHtml() {
    return $this->value;
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return empty($this->value);
  }

  /**
   * @param mixed $value
   * @return bool
   */
  static function isValidEnumerationKey($value) {
    return is_int($value) || is_string($value);
  }
}
