<?php

namespace contentfield\models\values;

use contentfield\models\fields\InstanceField;
use contentfield\models\schemas\AbstractSchema;

/**
 * Class InstanceValue
 *
 * @property InstanceField|null $field
 */
class InstanceValue extends AbstractValue
{
  /**
   * @var AbstractSchema
   */
  private $schema;

  /**
   * @var string
   */
  private $uuid;

  /**
   * @var AbstractValue[]
   */
  private $values = array();

  /**
   * @var string
   */
  const TYPE_PROPERTY = '__type';
  const UUID_PROPERTY = '__uuid';


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

    $this->schema = $schema;

    if (array_key_exists('uuid', $data)) {
      unset($data['uuid']);
      $this->uuid = $data['uuid'];
    } else {
      $this->uuid = self::uuid();
    }

    foreach ($schema->fields as $name => $field) {
      $this->$name = array_key_exists($name, $data) ? $data[$name] : null;
    }
  }

  /**
   * @inheritdoc
   */
  public function __get($name) {
    if (array_key_exists($name, $this->schema->fields)) {
      return $this->values[$name];
    } else {
      return parent::__get($name);
    }
  }

  /**
   * @inheritdoc
   * @throws \Exception
   */
  public function __set($name, $value) {
    if (array_key_exists($name, $this->schema->fields)) {
      $this->values[$name] = $this->schema->fields[$name]->createValue($value, $this);
    } else {
      parent::__set($name, $value);
    }
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
    return $this->schema->render($this);
  }

  /**
   * @inheritdoc
   */
  public function attributes() {
    return array_keys($this->schema->fields);
  }

  /**
   * @param array $result
   * @return array
   */
  public function getEagerLoadingMap(&$result = array()) {
    foreach ($this->values as $field) {
      $field->getEagerLoadingMap($result);
    }

    return $result;
  }

  /**
   * @return array
   */
  public function getEditorData() {
    $result = array();
    foreach ($this->values as $name => $value) {
      $result[$name] = $value->getEditorData();
    }

    $result[self::TYPE_PROPERTY] = $this->schema->qualifier;
    $result[self::UUID_PROPERTY] = $this->uuid;
    return $result;
  }

  /**
   * @inheritdoc
   */
  public function getHtml() {
    return new \Twig_Markup($this->schema->render($this), 'utf-8');
  }

  /**
   * @return AbstractValue[]
   */
  public function getValues() {
    return $this->values;
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
