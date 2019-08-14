<?php

namespace lenz\contentfield\models\values;

use Exception;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\helpers\BeforeActionInterface;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\helpers\ReferenceMappableInterface;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\Plugin;
use Throwable;
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
  private $_schema;

  /**
   * @var array
   */
  private $_values = [];


  /**
   * AbstractModelValue constructor.
   *
   * @param array $data
   * @param AbstractSchema $schema
   * @param ValueInterface|null $parent
   * @param InstanceField|null $field
   * @throws Exception
   */
  public function __construct(array $data, AbstractSchema $schema, ValueInterface $parent = null, InstanceField $field = null) {
    parent::__construct();

    $this->_field  = $field;
    $this->_parent = $parent;
    $this->_schema = $schema;

    foreach ($schema->fields as $name => $field) {
      $this->$name = array_key_exists($name, $data) ? $data[$name] : null;
    }
  }

  /**
   * @inheritdoc
   */
  public function __get($name) {
    if (
      substr($name, 0, 4) == 'raw:' &&
      array_key_exists(substr($name, 4), $this->_schema->fields)
    ) {
      return $this->_values[substr($name, 4)]->getEditorData();
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
  public function addError($attribute, $error = '') {
    if (substr($attribute, 0, 4) == 'raw:') {
      $attribute = substr($attribute, 4);
    }

    parent::addError($attribute, $error);
  }

  /**
   * @inheritDoc
   */
  public function attributeLabels() {
    return array_map(function(AbstractField $field) {
      return Plugin::t($field->label);
    }, $this->_schema->fields);
  }

  /**
   * @inheritdoc
   */
  public function attributes() {
    return array_keys($this->_schema->fields);
  }

  /**
   * @inheritDoc
   */
  public function findUuid(string $uuid) {
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
  public function findInstances($qualifier) {
    $result = array();
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
  public function getAttributeLabel($attribute) {
    if (substr($attribute, 0, 4) == 'raw:') {
      $attribute = substr($attribute, 4);
    }

    return parent::getAttributeLabel($attribute);
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue() {
    $result = [];
    foreach ($this->_schema->fields as $name => $field) {
      $result[$name] = $field->getEditorValue($this->_values[$name]);
    }

    return $result;
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
   * @return AbstractSchema
   */
  public function getSchema() {
    return $this->_schema;
  }

  /**
   * @inheritDoc
   */
  public function getSearchKeywords() {
    return implode(
      ' ',
      array_map(function(AbstractField $field) {
        return $field->getSearchKeywords($this->_values[$field->name]);
      }, $this->_schema->fields)
    );
  }

  /**
   * @inheritDoc
   */
  public function getSerializedValue() {
    $result = [];
    foreach ($this->_schema->fields as $name => $field) {
      $result[$name] = $field->getSerializedValue($this->_values[$name]);
    }

    return $result;
  }

  /**
   * @param string $name
   * @return mixed|null
   */
  public function getValue(string $name) {
    return array_key_exists($name, $this->_values)
      ? $this->_values[$name]
      : null;
  }

  /**
   * @return mixed[]
   */
  public function getValues() {
    return $this->_values;
  }

  /**
   * @inheritDoc
   */
  public function isEmpty() {
    return false;
  }

  /**
   * @inheritDoc
   * @throws Exception
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
  public function rules() {
    return $this->_schema->getValueRules();
  }
}
