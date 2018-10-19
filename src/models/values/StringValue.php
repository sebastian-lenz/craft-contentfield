<?php

namespace contentfield\models\values;

use contentfield\models\Content;
use contentfield\models\fields\StringField;

/**
 * Class StringValue
 *
 * @property StringField $field
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
   * @param StringField $field
   */
  public function __construct($data, AbstractValue $parent, StringField $field) {
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
    return new \Twig_Markup($this->field->widget->isHtmlWidget()
      ? $this->value
      : htmlentities($this->value)
    , 'utf-8');
  }
}
