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
use lenz\contentfield\helpers\ReferenceMappableInterface;
use lenz\contentfield\helpers\RenderableInterface;
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
  extends AbstractValue
  implements
    ArrayAccess,
    BeforeActionInterface,
    Countable,
    DisplayInterface,
    ReferenceMappableInterface,
    RenderableInterface,
    IteratorAggregate,
    ValueTraversableInterface
{
  /**
   * @var array
   */
  private $_values;

  /**
   * @var array
   */
  private $_visibleValues;


  /**
   * ArrayValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface|null $parent
   * @param ArrayField|null $field
   */
  public function __construct($data, ValueInterface $parent = null, ArrayField $field = null) {
    parent::__construct($parent, $field);

    $member = $this->_field->member;

    if (!is_array($data) || is_null($member)) {
      $this->_values = [];
    } else {
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
   * @inheritDoc
   * @throws Exception
   */
  public function display(array $variables = []) {
    $iterator = $this->getVisibleIterator();
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
  public function findInstances($qualifier): array {
    $result = [];

    foreach ($this->_values as $value) {
      if (!($value instanceof ValueTraversableInterface)) {
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
  public function findUuid(string $uuid): ?InstanceValue {
    foreach ($this->_values as $value) {
      if (!($value instanceof ValueTraversableInterface)) {
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
   * Returns the first visible value.
   *
   * @return mixed
   */
  public function getFirst() {
    foreach ($this->_values as $value) {
      if (
        !($value instanceof InstanceValue) ||
        $value->isVisible()
      ) {
        return $value;
      }
    }

    return null;
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
  public function getReferenceMap(ReferenceMap $map = null) {
    if (is_null($map)) {
      $map = new ReferenceMap();
    }

    foreach ($this->_values as $value) {
      if ($value instanceof ReferenceMappableInterface) {
        $value->getReferenceMap($map);
      }
    }

    return $map;
  }

  /**
   * @return array
   */
  public function getValues(): array {
    return $this->_values;
  }

  /**
   * Returns an array containing only visible values in the
   * array.
   *
   * @return array
   */
  public function getVisibleValues(): array {
    if (isset($this->_visibleValues)) {
      return $this->_visibleValues;
    }

    return $this->_visibleValues = array_filter($this->_values, function($value) {
      return (
        !($value instanceof InstanceValue) ||
        $value->isVisible()
      );
    });
  }

  /**
   * @return IteratorLoop
   * @throws Exception
   * @deprecated
   */
  public function getVisibleIterator(): IteratorLoop {
    return $this->getIterator();
  }

  /**
   * @inheritDoc
   */
  public function isEmpty(): bool {
    return $this->count() == 0;
  }

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
   * @inheritDoc
   */
  public function render(array $variables = [], array $options = []): string {
    $result = [];
    $iterator = $this->getIterator();
    $variables['loop'] = $iterator;

    foreach ($iterator as $value) {
      $result[] = $value instanceof RenderableInterface
        ? $value->render($variables, $options)
        : (string)$value;
    }

    return implode('', $result);
  }


  // ArrayAccess
  // -----------

  /**
   * @inheritdoc
   * @noinspection PhpMissingReturnTypeInspection (Interface method)
   */
  public function offsetExists($offset) {
    $values = $this->getVisibleValues();
    return array_key_exists($offset, $values);
  }

  /**
   * @inheritdoc
   */
  public function offsetGet($offset) {
    $values = $this->getVisibleValues();
    return $values[$offset];
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


  // Countable
  // ---------

  /**
   * @inheritdoc
   * @noinspection PhpMissingReturnTypeInspection (Interface method)
   */
  public function count() {
    return count($this->getVisibleValues());
  }


  // IteratorAggregate
  // -----------------

  /**
   * @inheritdoc
   */
  public function getIterator() {
    return new IteratorLoop($this->getVisibleValues());
  }
}
