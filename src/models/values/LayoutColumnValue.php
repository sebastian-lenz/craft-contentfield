<?php

namespace lenz\contentfield\models\values;

use craft\helpers\ArrayHelper;
use Exception;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\helpers\BeforeActionInterface;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\helpers\ReferenceMappableInterface;
use lenz\contentfield\helpers\RenderableInterface;
use lenz\contentfield\models\fields\LayoutField;
use lenz\contentfield\twig\DisplayInterface;
use Throwable;
use Twig\Markup;

/**
 * Class LayoutColumnValue
 *
 * @method LayoutField|null getField()
 * @property array $offset
 * @property array $order
 * @property string $uuid
 * @property array $width
 * @property LayoutField $_field
 * @property LayoutValue $_parent
 */
class LayoutColumnValue
  extends AbstractValue
  implements
    BeforeActionInterface,
    DisplayInterface,
    ReferenceMappableInterface,
    RenderableInterface,
    ValueTraversableInterface
{
  /**
   * @var array
   */
  private array $_offset;

  /**
   * @var array
   */
  private array $_order;

  /**
   * @var string
   */
  private string $_uuid;

  /**
   * @var mixed|null
   */
  private mixed $_value = null;

  /**
   * @var array
   */
  private array $_width;


  /**
   * ColumnsValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface|null $parent
   * @param LayoutField|null $field
   * @throws Exception
   */
  public function __construct($data, ValueInterface $parent = null, LayoutField $field = null) {
    parent::__construct($parent, $field);

    if (!($parent instanceof LayoutValue)) {
      throw new Exception('The parent of a LayoutColumnValue instance must be an instance of LayoutValue.');
    }

    if (!is_null($field) && is_array($data)) {
      $data = $field->normalizeBreakpointMaps($data);
    }

    $this->_uuid = ArrayHelper::getValue($data, '__uuid', InstanceValue::uuid());
    $this->_offset = ArrayHelper::getValue($data, 'offset', []);
    $this->_order = ArrayHelper::getValue($data, 'order', []);
    $this->_width = ArrayHelper::getValue($data, 'width', []);

    $member = $this->_field->member;
    try {
      $this->_value = $member->createValue($data['value'], $this);
    } catch (Throwable) {
      $this->_value = null;
    }
  }


  /**
   * @inheritDoc
   */
  function __toString(): string {
    return $this->render();
  }

  /**
   * @param array $variables
   */
  public function display(array $variables = []): void {
    if ($this->_value instanceof DisplayInterface) {
      $this->_value->display($variables);
    } else {
      echo $this->_value;
    }
  }

  /**
   * @inheritDoc
   */
  public function findInstances(array|string $qualifier): array {
    return $this->_value instanceof ValueTraversableInterface
      ? $this->_value->findInstances($qualifier)
      : [];
  }

  /**
   * @inheritDoc
   */
  public function findUuid(string $uuid): ?InstanceValue {
    return $this->_value instanceof ValueTraversableInterface
      ? $this->_value->findUuid($uuid)
      : null;
  }

  /**
   * @return array
   */
  public function getExtraClasses(): array {
    return $this->_parent->hasPreset()
      ? $this->_parent->getPresetAttribute($this, 'class')
      : [];
  }

  /**
   * @return array
   */
  public function getEditorValue(): array {
    $member = $this->_field->member;

    return [
      '__errors' => (object)null,
      '__role' => 'layoutColumn',
      '__type' => $this->_field->getColumnTypeQualifier(),
      '__uuid' => $this->_uuid,
      '__visible' => true,
      'offset' => $this->getOffset(),
      'order' => $this->getOrder(),
      'value' => is_null($member)
        ? null
        : $member->getEditorValue($this->_value),
      'width' => $this->getWidth(),
    ];
  }

  /**
   * @inheritDoc
   */
  public function getHtml(): Markup {
    return is_null($this->_value)
      ? new Markup('', 'utf-8')
      : $this->_value->getHtml();
  }

  /**
   * @return array
   */
  public function getOffset(): array {
    return $this->_parent->hasPreset()
      ? $this->_parent->getPresetAttribute($this, 'offset')
      : $this->_offset;
  }

  /**
   * @return array
   */
  public function getOrder(): array {
    return $this->_parent->hasPreset()
      ? $this->_parent->getPresetAttribute($this, 'order')
      : $this->_order;
  }

  /**
   * @inheritDoc
   */
  public function getReferenceMap(ReferenceMap $map = null): ReferenceMap {
    $map = is_null($map) ? new ReferenceMap() : $map;

    return $this->_value instanceof ReferenceMappableInterface
      ? $this->_value->getReferenceMap($map)
      : $map;
  }

  /**
   * @return array
   */
  public function getSerializedValue(): array {
    $member = $this->_field->member;
    $data = [
      '__uuid' => $this->_uuid,
      'value' => is_null($member)
        ? null
        : $member->getSerializedValue($this->_value),
    ];

    if (!$this->_parent->hasPreset()) {
      $data = array_merge($data, [
        'offset' => $this->_offset,
        'order' => $this->_order,
        'width' => $this->_width,
      ]);
    }

    return $data;
  }

  /**
   * @return string
   * @noinspection PhpUnused (Public API)
   */
  public function getUuid(): string {
    return $this->_uuid;
  }

  /**
   * @return mixed
   */
  public function getValue(): mixed {
    return $this->_value;
  }

  /**
   * @return array
   */
  public function getWidth(): array {
    return $this->_parent->hasPreset()
      ? $this->_parent->getPresetAttribute($this, 'width')
      : $this->_width;
  }

  /**
   * @inheritDoc
   */
  function isEmpty(): bool {
    return is_null($this->_value) || $this->_value->isEmpty();
  }

  /**
   * @inheritDoc
   */
  public function onBeforeAction(BeforeActionEvent $event): void {
    if ($this->_value instanceof BeforeActionInterface) {
      $this->_value->onBeforeAction($event);
    }
  }

  /**
   * @inheritDoc
   */
  public function render(array $variables = [], array $options = []): string {
    return $this->_value instanceof RenderableInterface
      ? $this->_value->render($variables, $options)
      : (string)$this->_value;
  }
}
