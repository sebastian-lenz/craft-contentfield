<?php

namespace sebastianlenz\contentfield\models\values;

use sebastianlenz\contentfield\models\fields\ArrayField;
use sebastianlenz\contentfield\models\fields\InstanceField;
use sebastianlenz\contentfield\utilities\ReferenceMap;

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
    $count = count($this->values);

    foreach ($this->values as $index => $value) {
      if ($value instanceof InstanceValue) {
        $result[] = (string)$value->getHtml([
          'loop' => [
            'index'     => $index + 1,
            'index0'    => $index,
            'revindex'  => $count - $index,
            'revindex0' => $count - $index - 1,
            'first'     => $index == 0,
            'last'      => $index == $count - 1,
            'length'    => $count,
            'parent'    => $this,
          ],
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
   * @param string|string[] $qualifier
   * @return InstanceValue[]
   */
  public function findInstances($qualifier) {
    $result = array();

    foreach ($this->values as $value) {
      $matches = $value->findInstances($qualifier);
      if (count($matches) > 0) {
        $result = array_merge($result, $matches);
      }
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
  public function getIterator() {
    return new \ArrayIterator($this->values);
  }

  /**
   * @inheritdoc
   */
  public function getReferenceMap(ReferenceMap $map = null) {
    if (is_null($map)) {
      $map = new ReferenceMap();
    }

    foreach ($this->values as $value) {
      $value->getReferenceMap($map);
    }

    return $map;
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
