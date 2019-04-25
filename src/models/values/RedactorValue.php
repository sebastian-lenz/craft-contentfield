<?php

namespace sebastianlenz\contentfield\models\values;

use sebastianlenz\contentfield\utilities\RedactorSettings;
use craft\redactor\FieldData;

use sebastianlenz\contentfield\models\fields\strings\RedactorField;

/**
 * Class RedactorValue
 *
 * @property RedactorField $_field
 */
class RedactorValue extends Value
{
  /**
   * @var FieldData
   */
  private $_value;


  /**
   * RedactorValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface $parent
   * @param RedactorField $field
   */
  public function __construct($data, ValueInterface $parent, RedactorField $field) {
    parent::__construct($parent, $field);
    $this->_value = new FieldData(is_string($data) ? $data : '');
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
    return $this->_value->getParsedContent();
  }

  /**
   * @inheritdoc
   */
  public function getEditorData() {
    return $this->_value->getRawContent();
  }

  /**
   * @inheritdoc
   */
  public function getHtml() {
    return $this->_value;
  }

  /**
   * @return FieldData
   */
  public function getRedactorFieldData() {
    return $this->_value;
  }

  /**
   * @return string
   */
  public function getSearchKeywords() {
    return $this->_value->getParsedContent();
  }

  /**
   * @inheritdoc
   */
  public function getSerializedData() {
    try {
      $field = $this->_field->getRedactorField();
      return $field->serializeValue($this->_value, $this->getElement());
    } catch (\Throwable $error) { }

    return $this->_value->getRawContent();
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return empty($this->_value->getRawContent());
  }
}
