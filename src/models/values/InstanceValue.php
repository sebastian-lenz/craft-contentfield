<?php

namespace sebastianlenz\contentfield\models\values;

use sebastianlenz\contentfield\models\fields\InstanceField;
use sebastianlenz\contentfield\models\schemas\AbstractSchema;
use sebastianlenz\contentfield\utilities\ReferenceMap;

/**
 * Class InstanceValue
 *
 * @property InstanceField|null $__field
 */
class InstanceValue extends AbstractValue
{
  /**
   * @var string
   */
  private $__originalUuid;

  /**
   * @var AbstractSchema
   */
  private $__schema;

  /**
   * @var string
   */
  private $__uuid;

  /**
   * @var AbstractValue[]
   */
  private $__values = array();

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
   * @param AbstractValue|null $parent
   * @param InstanceField|null $field
   * @throws \Exception
   */
  public function __construct(array $data, AbstractSchema $schema, AbstractValue $parent = null, InstanceField $field = null) {
    parent::__construct($parent, $field);

    $this->__schema = $schema;

    if (array_key_exists(self::UUID_PROPERTY, $data)) {
      $this->__uuid = $data[self::UUID_PROPERTY];
      unset($data[self::UUID_PROPERTY]);
    } else {
      $this->__uuid = self::uuid();
    }

    if (array_key_exists(self::ORIGINAL_UUID_PROPERTY, $data)) {
      $this->__originalUuid = $data[self::ORIGINAL_UUID_PROPERTY];
    }

    foreach ($schema->fields as $name => $field) {
      $this->$name = array_key_exists($name, $data) ? $data[$name] : null;
    }
  }

  /**
   * @inheritdoc
   */
  public function __get($name) {
    if (array_key_exists($name, $this->__schema->fields)) {
      return $this->__values[$name];
    } else {
      return parent::__get($name);
    }
  }

  /**
   * @inheritdoc
   * @throws \Exception
   */
  public function __set($name, $value) {
    if (array_key_exists($name, $this->__schema->fields)) {
      $this->__values[$name] = $this->__schema->fields[$name]->createValue($value, $this);
    } else {
      parent::__set($name, $value);
    }
  }

  /**
   * @inheritdoc
   */
  public function __isset($name) {
    if (array_key_exists($name, $this->__schema->fields)) {
      return true;
    } else {
      return parent::__isset($name);
    }
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
    if (!isset($this->__html)) {
      $this->__html = $this->__schema->render($this);
    }

    return $this->__html;
  }

  /**
   * @inheritdoc
   */
  public function attributes() {
    return array_keys($this->__schema->fields);
  }

  /**
   * @param string|string[] $qualifier
   * @return InstanceValue[]
   */
  public function findInstances($qualifier) {
    $result = array();
    if ($this->__schema->matchesQualifier($qualifier)) {
      $result[] = $this;
    }

    foreach ($this->__values as $value) {
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
    foreach ($this->__values as $name => $value) {
      if (!is_null($value)) {
        $result[$name] = $value->getEditorData();
      }
    }

    $result[self::TYPE_PROPERTY] = $this->__schema->qualifier;
    $result[self::UUID_PROPERTY] = $this->__uuid;
    $result[self::ORIGINAL_UUID_PROPERTY] = $this->__originalUuid;
    return $result;
  }

  /**
   * @inheritdoc
   */
  public function getHtml(array $variables = []) {
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

    return new \Twig_Markup($this->__schema->render($this, $variables), 'utf-8');
  }

  /**
   * @inheritdoc
   */
  public function getReferenceMap(ReferenceMap $map = null) {
    if (is_null($map)) {
      $map = new ReferenceMap();
    }

    foreach ($this->__values as $field) {
      if (!is_null($field)) {
        $field->getReferenceMap($map);
      }
    }

    return $map;
  }

  /**
   * @return array
   */
  public function getSerializedData() {
    $result = array();
    foreach ($this->__values as $name => $value) {
      if (!is_null($value)) {
        $result[$name] = $value->getSerializedData();
      }
    }

    $result[self::TYPE_PROPERTY] = $this->__schema->qualifier;
    $result[self::UUID_PROPERTY] = $this->__uuid;
    $result[self::ORIGINAL_UUID_PROPERTY] = $this->__originalUuid;
    return $result;
  }

  /**
   * @return string
   */
  public function getType() {
    return $this->__schema->qualifier;
  }

  /**
   * @return AbstractValue[]
   */
  public function getValues() {
    return $this->__values;
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return false;
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
