<?php

namespace contentfield\models\values;

use contentfield\models\fields\ArrayField;

/**
 * Class ArrayValue
 *
 * @property ArrayField $field
 */
class ArrayValue extends AbstractValue implements \ArrayAccess, \Countable, \IteratorAggregate
{
  /**
   * @var AbstractValue[]
   */
  private $values;


  /**
   * ArrayValue constructor.
   *
   * @param mixed $data
   * @param AbstractValue $parent
   * @param ArrayField $field
   */
  public function __construct($data, AbstractValue $parent, ArrayField $field) {
    parent::__construct($parent, $field);

    if (!is_array($data)) {
      $this->values = array();
    } else {
      $member = $this->field->member;
      $this->values = array_filter(array_map(function($value) use ($member) {
        return $member->createValue($value, $this);
      }, $data));
    }
  }

  /**
   * @return string
   */
  public function __toString() {
    $result = array();
    foreach ($this->values as $value) {
      $result[] = (string)$value;
    }

    return implode('', $result);
  }

  /**
   * @inheritdoc
   */
  public function count() {
    return count($this->values);
  }

  /**
   * @inheritdoc
   */
  public function getEagerLoadingMap(&$result = array()) {
    foreach ($this->values as $value) {
      $value->getEagerLoadingMap($result);
    }

    return $result;
  }

  /**
   * @return mixed
   */
  function getEditorData() {
    $result = array();
    foreach ($this->values as $value) {
      $result[] = $value->getEditorData();
    }

    return $result;
  }

  /**
   * @inheritdoc
   */
  function getHtml() {
    $result = array();
    foreach ($this->values as $value) {
      $result[] = (string)$value->getHtml();
    }

    return new \Twig_Markup(implode('', $result), 'utf-8');
  }

  /**
   * @inheritdoc
   */
  public function getIterator() {
    return new \ArrayIterator($this->values);
  }

  /**
   * @inheritdoc
   */
  public function offsetExists($offset) {
    return array_key_exists($offset, $this->values);
  }

  /**
   * @inheritdoc
   */
  public function offsetGet($offset) {
    return $this->values[$offset];
  }

  /**
   * @inheritdoc
   * @throws \Exception
   */
  public function offsetSet($offset, $value) { }

  /**
   * @inheritdoc
   * @throws \Exception
   */
  public function offsetUnset($offset) { }
}
