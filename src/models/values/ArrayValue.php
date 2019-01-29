<?php

namespace contentfield\models\values;

use contentfield\models\fields\ArrayField;
use contentfield\models\fields\InstanceField;

/**
 * Class ArrayValue
 *
 * @property ArrayField $__field
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
      $member = $this->__field->member;
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
    foreach ($this->values as $index => $value) {
      if ($value instanceof InstanceValue) {
        $result[] = (string)$value->getHtml([
          'count' => count($this->values),
          'index' => $index,
        ]);
      } else {
        $result[] = (string)$value;
      }
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
    return new \Twig_Markup((string)$this, 'utf-8');
  }

  /**
   * @inheritdoc
   */
  public function getIterator() {
    return new \ArrayIterator($this->values);
  }

  /**
   * @return mixed
   */
  function getSerializedData() {
    $result = array();
    foreach ($this->values as $value) {
      $result[] = $value->getSerializedData();
    }

    return $result;
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return $this->count() == 0;
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
