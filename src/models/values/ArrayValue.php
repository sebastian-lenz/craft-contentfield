<?php

namespace lenz\contentfield\models\values;

use ArrayAccess;
use Countable;
use Exception;
use IteratorAggregate;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\helpers\BeforeActionInterface;
use lenz\contentfield\helpers\IteratorLoop;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\models\fields\ArrayField;
use lenz\contentfield\twig\DisplayInterface;
use Throwable;
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
   * @param ValueInterface|null $parent
   * @param ArrayField|null $field
   */
  public function __construct($data, ValueInterface $parent = null, ArrayField $field = null) {
    parent::__construct($parent, $field);

    if (!is_array($data)) {
      $this->_values = array();
    } else {
      $member = $this->_field->member;
      $this->_values = array_filter(
        array_map(function($value) use ($member) {
          try {
            return $member->createValue($value, $this);
          } catch (Throwable $error) {
            return null;
          }
        }, $data)
      );
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
    $iterator = $this->getIterator();
    $variables['loop'] = $iterator;

    foreach ($iterator as $value) {
      if ($value instanceof InstanceValue) {
        $value->display($variables);
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
    return new IteratorLoop($this->_values);
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
    $iterator = $this->getIterator();
    $variables['loop'] = $iterator;

    foreach ($iterator as $value) {
      if ($value instanceof InstanceValue) {
        $result[] = (string)$value->getHtml($variables);
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
