<?php

namespace lenz\contentfield\models\values;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Exception;
use IteratorAggregate;
use lenz\contentfield\models\BeforeActionInterface;
use lenz\contentfield\models\fields\ArrayField;
use lenz\contentfield\utilities\ReferenceMap;
use lenz\contentfield\utilities\twig\DisplayInterface;
use Twig_Markup;
use yii\base\ActionEvent;

/**
 * Class ArrayValue
 *
 * @property ArrayField $_field
 */
class ArrayValue
  extends Value
  implements ArrayAccess, BeforeActionInterface, Countable, DisplayInterface, IteratorAggregate
{
  /**
   * @var ValueInterface[]
   */
  private $__values;


  /**
   * ArrayValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface $parent
   * @param ArrayField $field
   */
  public function __construct($data, ValueInterface $parent, ArrayField $field) {
    parent::__construct($parent, $field);

    if (!is_array($data)) {
      $this->__values = array();
    } else {
      $member = $this->_field->member;
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
   * @param array $variables
   */
  public function display(array $variables = []) {
    $count = count($this->__values);

    foreach ($this->__values as $index => $value) {
      if ($value instanceof InstanceValue) {
        $value->display($variables + [
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
        echo (string)$value;
      }
    }
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
    return new Twig_Markup($this->render($variables), 'utf-8');
  }

  /**
   * @inheritdoc
   */
  public function getIterator() {
    return new ArrayIterator($this->__values);
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
    return implode('', array_map(function(ValueInterface $value) {
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
   * @throws Exception
   */
  public function offsetSet($offset, $value) { }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function offsetUnset($offset) { }

  /**
   * @inheritDoc
   */
  public function onBeforeAction(ActionEvent $event) {
    foreach ($this->__values as $value) {
      if ($value instanceof BeforeActionInterface) {
        $value->onBeforeAction($event);
      }
    }
  }

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
