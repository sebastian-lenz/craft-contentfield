<?php

namespace contentfield\models\fields;

use craft\base\ElementInterface;

use contentfield\models\schemas\AbstractSchema;
use contentfield\models\values\AbstractValue;
use contentfield\models\values\InstanceValue;
use contentfield\Plugin;

/**
 * Class InstanceField
 *
 * A field that stores another ContentModel.
 */
class InstanceField extends AbstractField
{
  /**
   * @var AbstractSchema[]
   */
  public $schemas;

  /**
   * The internal name of this field.
   */
  const NAME = 'instance';

  /**
   * @inheritdoc
   */
  const VALUE_CLASS = InstanceValue::class;


  /**
   * ArrayField constructor.
   *
   * @param array $config
   * @throws \Exception
   */
  public function __construct(array $config = []) {
    if (array_key_exists('schemas', $config)) {
      $schemaManager = Plugin::getInstance()->schemas;
      $schemas = is_array($config['schemas'])
        ? $config['schemas']
        : explode(',', $config['schemas']);

      $specs = array_filter(array_map(function($spec) {
        return trim($spec);
      }, $schemas));

      $config['schemas'] = $schemaManager->getSchemas($specs);
    }

    parent::__construct($config);
  }

  /**
   * @inheritdoc
   */
  public function createValue($data, AbstractValue $parent) {
    if (count($this->schemas) === 0) {
      return null;
    }

    if (!is_array($data)) {
      $data = array();
    }

    $schema = isset($data[InstanceValue::TYPE_PROPERTY])
      ? $data[InstanceValue::TYPE_PROPERTY]
      : null;

    if (is_null($schema) || !in_array($schema, $this->schemas)) {
      $data[InstanceValue::TYPE_PROPERTY] = $this->schemas[0];
    }

    return Plugin::getInstance()->schemas->createValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getDependedSchemas() {
    return $this->schemas;
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    if (!is_array($this->schemas) || count($this->schemas) === 0) {
      return null;
    }

    $schemas = array();
    foreach ($this->schemas as $schema) {
      $schemas[] = $schema->qualifier;
    }

    return parent::getEditorData($element) + array(
      'schemas' => $schemas,
    );
  }

  /**
   * @inheritdoc
   */
  static function expandFieldConfig(&$config) {
    // Expand the type `instances` to an array of instance fields
    if ($config['type'] === 'instances') {
      $config = array_intersect_key($config, array(
        'collapsible' => true,
        'group'       => true,
        'name'        => true,
        'label'       => true,
        'width'       => true,
      )) + array(
        'type'  => ArrayField::NAME,
        'member' => array(
            'type' => self::NAME,
          ) + array_intersect_key($config, array(
            'name'    => true,
            'schemas' => true,
          )),
      );
    }
  }
}
