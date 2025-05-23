<?php

namespace lenz\contentfield\models\values;

use ArrayAccess;
use Countable;
use craft\base\ElementInterface;
use craft\helpers\ArrayHelper;
use Exception;
use IteratorAggregate;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\helpers\BeforeActionInterface;
use lenz\contentfield\helpers\grids\GridInterface;
use lenz\contentfield\helpers\loops\IteratorLoop;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\helpers\ReferenceMappableInterface;
use lenz\contentfield\helpers\RenderableInterface;
use lenz\contentfield\models\fields\LayoutField;
use lenz\contentfield\twig\DisplayInterface;
use Throwable;
use Twig\Markup;

/**
 * Class LayoutValue
 *
 * @method LayoutField|null getField()
 * @property LayoutField $_field
 */
class LayoutValue
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
   * @var LayoutColumnValue[]
   */
  private array $_columns;

  /**
   * @var string|null
   */
  private mixed $_preset;

  /**
   * @var string
   */
  private mixed $_uuid;


  /**
   * LayoutValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface|null $parent
   * @param LayoutField|null $field
   * @throws Exception
   */
  public function __construct($data, ValueInterface $parent = null, LayoutField $field = null) {
    parent::__construct($parent, $field);
    $data = is_array($data) ? $data : [];

    $this->_uuid = ArrayHelper::getValue($data, '__uuid', InstanceValue::uuid());
    $this->_preset = ArrayHelper::getValue($data, 'preset');
    $this->_columns = $this->createColumns(ArrayHelper::getValue($data, 'columns'));
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
   */
  public function display(array $variables = []): \Generator {
    yield from $this->getGrid()->display($this, $variables);
  }

  /**
   * @inheritDoc
   */
  public function findInstances(array|string $qualifier): array {
    $reducer = function($result, LayoutColumnValue $column) use ($qualifier) {
      return array_merge($result, $column->findInstances($qualifier));
    };

    return array_reduce($this->_columns, $reducer, []);
  }

  /**
   * @inheritDoc
   */
  public function findUuid(string $uuid): ?InstanceValue {
    foreach ($this->_columns as $column) {
      $result = $column->findUuid($uuid);

      if (!is_null($result)) {
        return $result;
      }
    }

    return null;
  }

  /**
   * @return LayoutColumnValue[]
   */
  public function getColumns(): array {
    return $this->_columns;
  }

  /**
   * @return array
   */
  public function getEditorValue(): array {
    return [
      '__role' => 'layout',
      '__uuid' => $this->_uuid,
      'preset' => $this->_preset,
      'columns' => array_map(function(LayoutColumnValue $column) {
        return $column->getEditorValue();
      }, $this->_columns),
    ];
  }

  /**
   * @return GridInterface
   */
  public function getGrid(): GridInterface {
    return $this->_field->getGrid();
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function getHtml(array $variables = []): Markup {
    return new Markup($this->render($variables), 'utf-8');
  }

  /**
   * @return string|null
   * @noinspection PhpUnused
   */
  public function getPreset(): ?string {
    return array_key_exists($this->_preset, $this->_field->presets)
      ? $this->_preset
      : null;
  }

  /**
   * @param LayoutColumnValue $column
   * @param string $attribute
   * @return array
   */
  public function getPresetAttribute(LayoutColumnValue $column, string $attribute): array {
    $index = array_search($column, $this->_columns, true);
    $preset = array_key_exists($this->_preset, $this->_field->presets)
      ? $this->_field->presets[$this->_preset]
      : null;

    if ($index === false || is_null($preset)) {
      return [];
    }

    try {
      $result = ArrayHelper::getValue($preset, ['columns', $index, $attribute]);
      return is_array($result) ? $result : [];
    } catch (Throwable) {
      return [];
    }
  }

  /**
   * @inheritdoc
   */
  public function getReferenceMap(ReferenceMap $map = null): ReferenceMap {
    $map = is_null($map) ? new ReferenceMap() : $map;
    foreach ($this->_columns as $column) {
      $column->getReferenceMap($map);
    }

    return $map;
  }

  /**
   * @param ElementInterface|null $element
   * @return array
   */
  public function getSerializedValue(ElementInterface $element = null): array {
    return [
      'preset' => $this->_preset,
      'columns' => array_map(function(LayoutColumnValue $column) use ($element) {
        return $column->getSerializedValue($element);
      }, $this->_columns),
    ];
  }

  /**
   * @return string
   * @noinspection PhpUnused (Public API)
   */
  public function getUuid(): string {
    return $this->_uuid;
  }

  /**
   * @return array
   */
  public function getValues(): array {
    return array_map(function(LayoutColumnValue $column) {
      return $column->getValue();
    }, $this->_columns);
  }

  /**
   * @return bool
   */
  public function hasPreset(): bool {
    return (
      !is_null($this->_preset) &&
      array_key_exists($this->_preset, $this->_field->presets)
    );
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
    foreach ($this->_columns as $column) {
      $column->onBeforeAction($event);
    }
  }

  /**
   * @inheritDoc
   */
  public function render(array $variables = [], array $options = []): string {
    return $this->getGrid()->render($this, $variables, $options);
  }


  // ArrayAccess
  // -----------

  /**
   * @inheritdoc
   */
  public function offsetExists($offset): bool {
    return array_key_exists($offset, $this->_columns);
  }

  /**
   * @inheritdoc
   */
  public function offsetGet($offset): ?LayoutColumnValue {
    return array_key_exists($offset, $this->_columns)
      ? $this->_columns[$offset]
      : null;
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
   * @inheritDoc
   */
  public function count(): int {
    return count($this->_columns);
  }


  // IteratorAggregate
  // -----------------

  /**
   * @inheritdoc
   */
  public function getIterator(): IteratorLoop {
    return new IteratorLoop($this->_columns);
  }


  // Private methods
  // ---------------

  /**
   * @param mixed $columns
   * @return LayoutColumnValue[]
   */
  private function createColumns(mixed $columns): array {
    $result = [];
    if (!is_array($columns)) {
      return $result;
    }

    foreach ($columns as $column) {
      try {
        $result[] = new LayoutColumnValue($column, $this, $this->_field);
      } catch (Throwable) {
        // Ignore errors
      }
    }

    return $result;
  }
}
