<?php

namespace contentfield\models\values;

use contentfield\utilities\RedactorSettings;
use craft\redactor\FieldData;

use contentfield\models\fields\strings\RedactorField;

/**
 * Class RedactorValue
 *
 * @property RedactorField $__field
 */
class RedactorValue extends AbstractValue
{
  /**
   * @var FieldData
   */
  private $value;


  /**
   * StringValue constructor.
   *
   * @param mixed $data
   * @param AbstractValue $parent
   * @param RedactorField $field
   */
  public function __construct($data, AbstractValue $parent, RedactorField $field) {
    parent::__construct($parent, $field);
    $this->value = new FieldData(is_string($data) ? $data : '');
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
    return $this->value->getParsedContent();
  }

  /**
   * @inheritdoc
   */
  public function getEditorData() {
    return $this->value->getRawContent();
  }

  /**
   * @inheritdoc
   */
  public function getHtml() {
    return $this->value;
  }

  /**
   * @return FieldData
   */
  public function getRedactorFieldData() {
    return $this->value;
  }

  /**
   * @inheritdoc
   */
  public function getSerializedData() {
    try {
      $field = $this->__field->getRedactorField();
      return $field->serializeValue($this->value, $this->getElement());
    } catch (\Throwable $error) { }

    return $this->value->getRawContent();
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return empty($this->value->getRawContent());
  }
}
