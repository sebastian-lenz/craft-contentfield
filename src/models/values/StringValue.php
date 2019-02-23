<?php

namespace contentfield\models\values;

use contentfield\models\fields\strings\AbstractStringField;

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
  private $value;


  /**
   * StringValue constructor.
   *
   * @param mixed $data
   * @param AbstractValue $parent
   * @param AbstractStringField $field
   */
  public function __construct($data, AbstractValue $parent, AbstractStringField $field) {
    parent::__construct($parent, $field);
    $this->value = is_string($data) ? $data : '';
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
    return $this->value;
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
    return new \Twig_Markup($this->__field->isHtmlField()
      ? $this->value
      : htmlentities($this->value)
    , 'utf-8');
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return empty($this->value);
  }
}
