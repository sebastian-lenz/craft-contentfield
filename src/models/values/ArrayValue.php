<?php

namespace lenz\contentfield\models\values;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Exception;
use IteratorAggregate;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\models\BeforeActionInterface;
use lenz\contentfield\models\fields\ArrayField;
use lenz\contentfield\models\ReferenceMapValueInterface;
use lenz\contentfield\models\TraversableValueInterface;
use lenz\contentfield\utilities\ReferenceMap;
use lenz\contentfield\utilities\twig\DisplayInterface;
use Twig\Markup;

/**
 * Class ArrayValue
 *
 * @property ArrayField $_field
 */
class ArrayValue
  extends Value
  implements
    ArrayAccess,
    BeforeActionInterface,
    Countable,
    DisplayInterface,
    ReferenceMapValueInterface,
    IteratorAggregate,
    TraversableValueInterface
{
  /**
   * @var ValueInterface[]
   */
  private $_values;


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
      $this->_values = array();
    } else {
      $member = $this->_field->member;
      $this->_values = array_filter(array_map(function($value) use ($member) {
        return $member->createValue($value, $this);
      }, $data));
    }
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function __toString() {
    return $this->render();
  }

  /**
   * @inheritdoc
   */
  public function count() {
    return count($this->_values);
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function display(array $variables = []) {
    $count = count($this->_values);

    foreach ($this->_values as $index => $value) {
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
   * @inheritDoc
   */
  public function findInstances($qualifier) {
    $result = array();

    foreach ($this->_values as $value) {
      if (!($value instanceof TraversableValueInterface)) {
        continue;
      }

      $matches = $value->findInstances($qualifier);
      if (count($matches) > 0) {
        $result = array_merge($result, $matches);
      }
    }

    return $result;
  }

  /**
   * @inheritDoc
   */
  public function findUuid(string $uuid) {
    foreach ($this->_values as $value) {
      if (!($value instanceof TraversableValueInterface)) {
        continue;
      }

      $result = $value->findUuid($uuid);
      if (!is_null($result)) {
        return $result;
      }
    }

    return null;
  }

  /**
   * @return ValueInterface
   */
  public function getFirst() {
    return count($this->_values) > 0
      ? $this->_values[0]
      : null;
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function getHtml(array $variables = []) {
    return new Markup($this->render($variables), 'utf-8');
  }

  /**
   * @inheritdoc
   */
  public function getIterator() {
    return new ArrayIterator($this->_values);
  }

  /**
   * @inheritdoc
   */
  public function getReferenceMap(ReferenceMap $map = null) {
    if (is_null($map)) {
      $map = new ReferenceMap();
    }

    foreach ($this->_values as $value) {
      if ($value instanceof ReferenceMapValueInterface) {
        $value->getReferenceMap($map);
      }
    }

    return $map;
  }

  /**
   * @inheritDoc
   */
  public function isEmpty() {
    return $this->count() == 0;
  }

  /**
   * @inheritdoc
   */
  public function offsetExists($offset) {
    return array_key_exists($offset, $this->_values);
  }

  /**
   * @inheritdoc
   */
  public function offsetGet($offset) {
    return $this->_values[$offset];
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
  public function onBeforeAction(BeforeActionEvent $event) {
    foreach ($this->_values as $value) {
      if ($value instanceof BeforeActionInterface) {
        $value->onBeforeAction($event);
      }
    }
  }

  /**
   * @param array $variables
   * @return string
   * @throws Exception
   */
  public function render(array $variables = []) {
    $result = array();
    $count = count($this->_values);

    foreach ($this->_values as $index => $value) {
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

  /**
   * @return ValueInterface[]
   */
  public function toArray() {
    return $this->_values;
  }
}
