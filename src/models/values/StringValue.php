<?php

namespace sebastianlenz\contentfield\models\values;

use sebastianlenz\contentfield\models\fields\strings\AbstractStringField;

/**
 * Class StringValue
 *
 * @property AbstractStringField $__field
 */
class StringValue extends AbstractValue
{
  /**
   * @var string
   */
  private $_value;


  /**
   * StringValue constructor.
   *
   * @param mixed $data
   * @param AbstractValue $parent
   * @param AbstractStringField $field
   */
  public function __construct($data, AbstractValue $parent, AbstractStringField $field) {
    parent::__construct($parent, $field);
    $this->_value = is_string($data) ? $data : '';
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
    return $this->_value;
  }

  /**
   * @inheritdoc
   */
  public function getEditorData() {
    return $this->_value;
  }

  /**
   * @inheritdoc
   */
  public function getHtml() {
    return new \Twig_Markup($this->__field->isHtmlField()
      ? $this->_value
      : htmlentities($this->_value)
    , 'utf-8');
  }

  /**
   * @inheritDoc
   */
  public function getSearchKeywords() {
    return $this->_value;
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return empty($this->_value);
  }
}
