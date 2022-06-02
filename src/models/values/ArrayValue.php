<?php

namespace lenz\contentfield\models\values;

use ArrayAccess;
use Countable;
use Exception;
use IteratorAggregate;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\helpers\BeforeActionInterface;
use lenz\contentfield\helpers\loops\IteratorLoop;
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
  private array $_values;

  /**
   * @var array
   */
  private array $_visibleValues;


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
          } catch (Throwable) {
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
  public function __toString(): string {
    return $this->render();
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function display(array $variables = []): void {
    $iterator = $this->getIterator();
    $variables['loop'] = $iterator;

    foreach ($iterator as $value) {
      if ($value instanceof InstanceValue) {
        $value->display($variables);
      } else {
        echo $value;
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function findInstances(array|string $qualifier): array {
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
   * @noinspection PhpUnused
   */
  public function getFirst(): mixed {
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
  public function getHtml(array $variables = []): Markup {
    return new Markup($this->render($variables), 'utf-8');
  }

  /**
   * @inheritdoc
   */
  public function getReferenceMap(ReferenceMap $map = null): ReferenceMap {
    $map = is_null($map) ? new ReferenceMap() : $map;
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
   * Returns an array containing only visible values in the array.
   *
   * @return array
   */
  public function getVisibleValues(): array {
    if (isset($this->_visibleValues)) {
      return $this->_visibleValues;
    }

    $result = [];
    foreach ($this->_values as $value) {
      if (!($value instanceof InstanceValue) || $value->isVisible()) {
        $result[] = $value;
      }
    }

    return ($this->_visibleValues = $result);
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
  public function onBeforeAction(BeforeActionEvent $event): void {
    foreach ($this->_values as $value) {
      if ($value instanceof BeforeActionInterface) {
        $value->onBeforeAction($event);
      }
    }
  }

  /**
   * @inheritDoc
   * @throws Exception
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

  /**
   * @param array $value
   * @noinspection PhpUnused
   */
  public function setVisibleValues(array $value) {
    $this->_visibleValues = $value;
  }


  // ArrayAccess
  // -----------

  /**
   * @inheritdoc
   */
  public function offsetExists($offset): bool {
    $values = $this->getVisibleValues();
    return array_key_exists($offset, $values);
  }

  /**
   * @inheritdoc
   */
  public function offsetGet($offset): mixed {
    $values = $this->getVisibleValues();
    return $values[$offset];
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function offsetSet($offset, $value): void { }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function offsetUnset($offset): void { }


  // Countable
  // ---------

  /**
   * @inheritdoc
   */
  public function count(): int {
    return count($this->getVisibleValues());
  }


  // IteratorAggregate
  // -----------------

  /**
   * @inheritdoc
   */
  public function getIterator(): IteratorLoop {
    return new IteratorLoop($this->getVisibleValues());
  }
}
