<?php

namespace lenz\contentfield\models\values;

use craft\helpers\Template;
use lenz\contentfield\models\fields\booleans\AbstractBooleanField;

/**
 * Class BooleanValue
 *
 * @property AbstractBooleanField $_field
 */
class BooleanValue extends Value
{
  /**
   * @var boolean
   */
  private $_value;


  /**
   * BooleanValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface $parent
   * @param AbstractBooleanField $field
   */
  public function __construct($data, ValueInterface $parent = null, AbstractBooleanField $field = null) {
    parent::__construct($parent, $field);
    $this->_value = !!$data;
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
    return $this->_value ? 'true' : 'false';
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
    return Template::raw((string)$this);
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return !$this->_value;
  }
}
