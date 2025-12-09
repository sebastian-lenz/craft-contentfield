<?php

namespace lenz\contentfield\models\values;

use Craft;
use craft\base\ElementInterface;
use Exception;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\events\InstanceSearchKeywordsEvent;
use lenz\contentfield\helpers\BeforeActionInterface;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\helpers\ReferenceMappableInterface;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\Plugin;
use Throwable;
use yii\base\Event;
use yii\base\Model;

/**
 * Class AbstractModelValue
 */
abstract class AbstractModelValue
  extends Model
  implements BeforeActionInterface, ReferenceMappableInterface, ValueTraversableInterface, ValueInterface
{
  use ValueTrait;

  /**
   * @var AbstractSchema
   */
  private AbstractSchema $_schema;

  /**
   * @var array
   */
  private array $_values = [];

  /**
   * @var string
   */
  const EVENT_COLLECT_SEARCH_KEYWORDS = 'createSearchKeywords';


  /**
   * AbstractModelValue constructor.
   *
   * @param array $data
   * @param AbstractSchema $schema
   * @param ValueInterface|null $parent
   * @param InstanceField|null $field
   * @param Content|null $content
   */
  public function __construct(array $data, AbstractSchema $schema, ValueInterface $parent = null, InstanceField $field = null, Content $content = null) {
    parent::__construct();

    $this->_field  = $field;
    $this->_parent = $parent;
    $this->_schema = $schema;
    $this->_content = $content;

    foreach ($schema->fields as $name => $field) {
      $this->$name = array_key_exists($name, $data) ? $data[$name] : null;
    }
  }

  /**
   * @inheritdoc
   */
  public function __get($name) {
    if (
      str_starts_with($name, 'raw:') &&
      array_key_exists(substr($name, 4), $this->_schema->fields)
    ) {
      $name = substr($name, 4);
      return $this->_schema
        ->getField($name)
        ->getEditorValue($this->_values[$name]);
    } elseif (array_key_exists($name, $this->_schema->fields)) {
      return $this->_values[$name];
    } elseif ($this->_schema->hasConstant($name)) {
      return $this->_schema->getConstant($name);
    } else {
      return parent::__get($name);
    }
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function __set($name, $value) {
    if (array_key_exists($name, $this->_schema->fields)) {
      $this->_values[$name] = $this->_schema->fields[$name]->createValue($value, $this);
    } else {
      parent::__set($name, $value);
    }
  }

  /**
   * @inheritdoc
   */
  public function __isset($name) {
    if (array_key_exists($name, $this->_schema->fields)) {
      return true;
    } elseif ($this->_schema->hasConstant($name)) {
      return true;
    } else {
      return parent::__isset($name);
    }
  }

  /**
   * @inheritDoc
   */
  public function addError($attribute, $error = ''): void {
    if (str_starts_with($attribute, 'raw:')) {
      $attribute = substr($attribute, 4);
    }

    parent::addError($attribute, $error);
  }

  /**
   * @inheritDoc
   */
  public function attributeLabels(): array {
    return array_map(function(AbstractField $field) {
      return Plugin::t($field->label);
    }, $this->_schema->fields);
  }

  /**
   * @inheritdoc
   */
  public function attributes(): array {
    return array_keys($this->_schema->fields);
  }

  /**
   * @inheritDoc
   */
  public function findUuid(string $uuid): ?InstanceValue {
    foreach ($this->_values as $value) {
      if ($value instanceof ValueTraversableInterface) {
        $result = $value->findUuid($uuid);
        if (!is_null($result)) {
          return $result;
        }
      }
    }

    return null;
  }

  /**
   * @param string|string[] $qualifier
   * @return InstanceValue[]
   * @throws Throwable
   */
  public function findInstances(array|string $qualifier): array {
    $result = [];
    if ($this->_schema->matchesQualifier($qualifier)) {
      $result[] = $this;
    }

    foreach ($this->_values as $value) {
      if ($value instanceof ValueTraversableInterface) {
        $matches = $value->findInstances($qualifier);
        if (count($matches) > 0) {
          $result = array_merge($result, $matches);
        }
      }
    }

    return $result;
  }

  /**
   * @inheritDoc
   */
  public function getAttributeLabel($attribute): string {
    if (str_starts_with($attribute, 'raw:')) {
      $attribute = substr($attribute, 4);
    }

    return parent::getAttributeLabel($attribute);
  }

  /**
   * @param string $name
   * @param mixed|null $default
   * @return mixed
   * @noinspection PhpUnused
   */
  public function getConstant(string $name, mixed $default = null): mixed {
    return $this->_schema->getConstant($name, $default);
  }

  /**
   * @return array
   */
  public function getEditorValue(): array {
    $result = [];
    foreach ($this->_schema->fields as $name => $field) {
      $result[$name] = $field->getEditorValue($this->_values[$name]);
    }

    return $result;
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
   * @return AbstractSchema
   */
  public function getSchema(): AbstractSchema {
    return $this->_schema;
  }

  /**
   * @return string
   */
  public function getSearchKeywords(): string {
    $keywords = [];
    foreach ($this->_schema->fields as $field) {
      $keywords[$field->name] = $field->getSearchKeywords($this->_values[$field->name]);
    }

    if (Event::hasHandlers(self::class, self::EVENT_COLLECT_SEARCH_KEYWORDS)) {
      $event = new InstanceSearchKeywordsEvent([
        'instance' => $this,
        'keywords' => $keywords,
      ]);

      Event::trigger(self::class, self::EVENT_COLLECT_SEARCH_KEYWORDS, $event);
      $keywords = $event->keywords;
    }

    return implode(' ', array_filter(array_values($keywords)));
  }

  /**
   * @param ElementInterface|null $element
   * @return array
   */
  public function getSerializedValue(ElementInterface $element = null): array {
    $result = [];
    foreach ($this->_schema->fields as $name => $field) {
      $result[$name] = $field->getSerializedValue($this->_values[$name], $element);
    }

    return $result;
  }

  /**
   * @param string $name
   * @return mixed|null
   */
  public function getValue(string $name): mixed {
    return array_key_exists($name, $this->_values)
      ? $this->_values[$name]
      : null;
  }

  /**
   * @return array
   */
  public function getValues(): array {
    return $this->_values;
  }

  /**
   * @param string|string[] $specs
   * @return bool
   */
  public function is(array|string $specs): bool {
    try {
      return $this->_schema->matchesQualifier($specs);
    } catch (Throwable $e) {
      Craft::error($e->getMessage());
      return false;
    }
  }

  /**
   * @inheritDoc
   */
  public function isEmpty(): bool {
    return false;
  }

  /**
   * @inheritDoc
   * @throws Exception
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
   */
  public function rules(): array {
    return $this->_schema->getValueRules();
  }
}
