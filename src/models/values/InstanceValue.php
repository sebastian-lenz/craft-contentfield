<?php

namespace lenz\contentfield\models\values;

use craft\base\Model;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\utilities\ReferenceMap;

/**
 * Class InstanceValue
 *
 * @property InstanceField|null $_field
 */
class InstanceValue extends Model implements ValueInterface
{
  use ValueTrait;

  /**
   * @var string
   */
  private $_output;

  /**
   * @var string
   */
  private $_originalUuid;

  /**
   * @var AbstractSchema
   */
  private $_schema;

  /**
   * @var string
   */
  private $_uuid;

  /**
   * @var ValueInterface[]
   */
  private $_values = array();

  /**
   * @var string
   */
  const TYPE_PROPERTY = '__type';
  const UUID_PROPERTY = '__uuid';
  const ORIGINAL_UUID_PROPERTY = '__originalUuid';


  /**
   * TypedModel constructor.
   *
   * @param array $data
   * @param AbstractSchema $schema
   * @param ValueInterface|null $parent
   * @param InstanceField|null $field
   * @throws \Exception
   */
  public function __construct(array $data, AbstractSchema $schema, ValueInterface $parent = null, InstanceField $field = null) {
    parent::__construct();
    $this->_field = $field;
    $this->_parent = $parent;

    $this->_schema = $schema;

    if (array_key_exists(self::UUID_PROPERTY, $data)) {
      $this->_uuid = $data[self::UUID_PROPERTY];
      unset($data[self::UUID_PROPERTY]);
    } else {
      $this->_uuid = self::uuid();
    }

    if (array_key_exists(self::ORIGINAL_UUID_PROPERTY, $data)) {
      $this->_originalUuid = $data[self::ORIGINAL_UUID_PROPERTY];
    }

    foreach ($schema->fields as $name => $field) {
      $this->$name = array_key_exists($name, $data) ? $data[$name] : null;
    }
  }

  /**
   * @inheritdoc
   */
  public function __get($name) {
    if (array_key_exists($name, $this->_schema->fields)) {
      return $this->_values[$name];
    } else {
      return parent::__get($name);
    }
  }

  /**
   * @inheritdoc
   * @throws \Exception
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
    } else {
      return parent::__isset($name);
    }
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
    return $this->render();
  }

  /**
   * @inheritdoc
   */
  public function attributes() {
    return array_keys($this->_schema->fields);
  }

  /**
   * @param string|string[] $qualifier
   * @return InstanceValue[]
   */
  public function findInstances($qualifier) {
    $result = array();
    if ($this->_schema->matchesQualifier($qualifier)) {
      $result[] = $this;
    }

    foreach ($this->_values as $value) {
      if (!is_null($value)) {
        $matches = $value->findInstances($qualifier);
        if (count($matches) > 0) {
          $result = array_merge($result, $matches);
        }
      }
    }

    return $result;
  }

  /**
   * @return array
   */
  public function getEditorData() {
    $result = array();
    foreach ($this->_values as $name => $value) {
      if (!is_null($value)) {
        $result[$name] = $value->getEditorData();
      }
    }

    $result[self::TYPE_PROPERTY] = $this->_schema->qualifier;
    $result[self::UUID_PROPERTY] = $this->_uuid;
    $result[self::ORIGINAL_UUID_PROPERTY] = $this->_originalUuid;
    return $result;
  }

  /**
   * @inheritdoc
   */
  public function getHtml(array $variables = []) {
    return new \Twig_Markup($this->render($variables), 'utf-8');
  }

  /**
   * @inheritdoc
   */
  public function getReferenceMap(ReferenceMap $map = null) {
    if (is_null($map)) {
      $map = new ReferenceMap();
    }

    foreach ($this->_values as $field) {
      if (!is_null($field)) {
        $field->getReferenceMap($map);
      }
    }

    return $map;
  }

  /**
   * @inheritDoc
   */
  public function getSearchKeywords() {
    return implode(' ', array_map(function(ValueInterface $value) {
      $value->getSearchKeywords();
    }, $this->_values));
  }

  /**
   * @return array
   */
  public function getSerializedData() {
    $result = array();
    foreach ($this->_values as $name => $value) {
      if (!is_null($value)) {
        $result[$name] = $value->getSerializedData();
      }
    }

    $result[self::TYPE_PROPERTY] = $this->_schema->qualifier;
    $result[self::UUID_PROPERTY] = $this->_uuid;
    $result[self::ORIGINAL_UUID_PROPERTY] = $this->_originalUuid;
    return $result;
  }

  /**
   * @return string
   */
  public function getType() {
    return $this->_schema->qualifier;
  }

  /**
   * @return ValueInterface[]
   */
  public function getValues() {
    return $this->_values;
  }

  /**
   * @return bool
   */
  public function hasCachedOutput() {
    return isset($this->_output);
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return false;
  }

  /**
   * @param array $variables
   * @return string
   */
  public function render(array $variables = []) {
    if (isset($this->_output)) {
      return $this->_output;
    }

    if (!array_key_exists('loop', $variables)) {
      $variables['loop'] = [
        'index'     => 1,
        'index0'    => 0,
        'revindex'  => 1,
        'revindex0' => 0,
        'first'     => true,
        'last'      => true,
        'length'    => 1,
        'parent'    => [],
      ];
    }

    return $this->_schema->render($this, $variables);
  }

  /**
   * @param string $value
   */
  public function setCachedOutput($value) {
    $this->_output = $value;
  }

  /**
   * @return string
   * @throws \Exception
   */
  static function uuid() {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }
}
