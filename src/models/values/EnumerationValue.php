<?php

namespace lenz\contentfield\models\values;

use lenz\contentfield\models\enumerations\CustomDataInterface;
use lenz\contentfield\models\fields\AbstractEnumerationField;

/**
 * Class EnumerationValue
 *
 * @property AbstractEnumerationField $_field
 */
class EnumerationValue extends AbstractValue
{
  /**
   * @var string|int
   */
  private string|int $_value;


  /**
   * EnumerationValue constructor.
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
  public function __get(string $name): mixed {
    return $this->getCustomData($name);
  }

  /**
   * @param string $name
   * @return bool
   */
  public function __isset(string $name) {
    $enumeration = $this->_field->getEnumeration();
    if ($enumeration instanceof CustomDataInterface) {
      return $enumeration->hasCustomData($this->_value, $name);
    }

    return false;
  }

  /**
   * @inheritdoc
   */
  public function __toString(): string {
    return (string)$this->_value;
  }

  /**
   * @param string|int $value
   * @return bool
   */
  public function contains(string|int $value): bool {
    return $this->_value == $value;
  }

  /**
   * @param string $name
   * @return mixed
   */
  public function getCustomData(string $name): mixed {
    $enumeration = $this->_field->getEnumeration();
    if (
      $enumeration instanceof CustomDataInterface &&
      $enumeration->hasCustomData($this->_value, $name)
    ) {
      return $enumeration->getCustomData($this->_value, $name);
    }

    return null;
  }

  /**
   * @return int|string
   */
  public function getValue(): int|string {
    return $this->_value;
  }

  /**
   * @inheritDoc
   */
  public function isEmpty(): bool {
    return empty($this->_value);
  }


  // Static methods
  // --------------

  /**
   * @param mixed $value
   * @return bool
   */
  static public function isValidEnumerationKey(mixed $value): bool {
    return is_int($value) || is_string($value);
  }
}
