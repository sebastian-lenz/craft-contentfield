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
  private $__values;


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
      $this->__values = array();
    } else {
      $member = $this->__field->member;
      $this->__values = array_filter(array_map(function($value) use ($member) {
        return $member->createValue($value, $this);
      }, $data));
    }
  }

  /**
   * @return string
   */
  public function __toString() {
    return $this->render();
  }

  /**
   * @inheritdoc
   */
  public function count() {
    return count($this->__values);
  }

  /**
   * @param string|string[] $qualifier
   * @return InstanceValue[]
   */
  public function findInstances($qualifier) {
    $result = array();

    foreach ($this->__values as $value) {
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
    foreach ($this->__values as $value) {
      $result[] = $value->getEditorData();
    }

    return $result;
  }

  /**
   * @inheritDoc
   */
  public function getHtml(array $variables = []) {
    return new \Twig_Markup($this->render($variables), 'utf-8');
  }

  /**
   * @inheritdoc
   */
  public function getIterator() {
    return new \ArrayIterator($this->__values);
  }

  /**
   * @inheritdoc
   */
  public function getReferenceMap(ReferenceMap $map = null) {
    if (is_null($map)) {
      $map = new ReferenceMap();
    }

    foreach ($this->__values as $value) {
      $value->getReferenceMap($map);
    }

    return $map;
  }

  /**
   * @inheritDoc
   */
  public function getSearchKeywords() {
    return implode('', array_map(function(AbstractValue $value) {
      $value->getSearchKeywords();
    }, $this->__values));
  }

  /**
   * @return mixed
   */
  function getSerializedData() {
    $result = array();
    foreach ($this->__values as $value) {
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
    return array_key_exists($offset, $this->__values);
  }

  /**
   * @inheritdoc
   */
  public function offsetGet($offset) {
    return $this->__values[$offset];
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

  /**
   * @param array $variables
   * @return string
   */
  public function render(array $variables = []) {
    $result = array();
    $count = count($this->__values);

    foreach ($this->__values as $index => $value) {
      if ($value instanceof InstanceValue) {
        $result[] = (string)$value->getHtml($variables + [
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
}
