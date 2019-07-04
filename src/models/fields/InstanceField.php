<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;

use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\Plugin;
use lenz\contentfield\services\SchemaManager;
use lenz\contentfield\validators\InstanceValueValidator;
use Throwable;

/**
 * Class InstanceField
 *
 * A field that stores another ContentModel.
 */
class InstanceField extends AbstractField
{
  /**
   * @var string[]
   */
  public $schemas;

  /**
   * @var AbstractSchema
   */
  private $_parentSchema;

  /**
   * @var AbstractSchema[]
   */
  private $_resolvedSchemas;

  /**
   * The internal name of this field.
   */
  const NAME = 'instance';

  /**
   * @inheritdoc
   */
  const VALUE_CLASS = InstanceValue::class;


  /**
   * InstanceField constructor.
   *
   * @param AbstractSchema $schema
   * @param array $config
   * @throws Throwable
   */
  public function __construct(AbstractSchema $schema, array $config = []) {
    $this->_parentSchema = $schema;

    if (array_key_exists('schemas', $config)) {
      $config['schemas'] = is_array($config['schemas'])
        ? $config['schemas']
        : explode(',', $config['schemas']);
    }

    parent::__construct($schema, $config);
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function createValue($data, ValueInterface $parent) {
    if (count($this->schemas) === 0) {
      return null;
    }

    if (!is_array($data)) {
      $data = array();
    }

    $schema = isset($data[InstanceValue::TYPE_PROPERTY])
      ? $data[InstanceValue::TYPE_PROPERTY]
      : null;

    if (is_null($schema) || !$this->isValidSchema($schema)) {
      $schemas = $this->getDependedSchemas();
      $data[InstanceValue::TYPE_PROPERTY] = $schemas[0]->qualifier;
    }

    return Plugin::getInstance()->schemas->createValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function getDependedSchemas() {
    if (!isset($this->_resolvedSchemas)) {
      $schemaManager = Plugin::getInstance()->schemas;
      $parentSchema  = $this->_parentSchema;
      $localSchemas  = [];
      $qualifiers    = [];

      foreach ($this->schemas as $schema) {
        $schema = trim((string)$schema);
        if ($parentSchema->hasLocalStructure($schema)) {
          $localSchemas[] = $parentSchema->getLocalStructure($schema);
        } elseif (!empty($schema)) {
          $qualifiers[] = $schema;
        }
      }

      $this->_resolvedSchemas = array_merge(
        $localSchemas,
        $schemaManager->getSchemas($qualifiers)
      );
    }

    return $this->_resolvedSchemas;
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function getEditorData(ElementInterface $element = null) {
    $qualifiers = array_map(function(AbstractSchema $schema) {
      return $schema->qualifier;
    }, $this->getDependedSchemas());

    if (count($qualifiers) === 0) {
      return null;
    }

    return parent::getEditorData($element) + array(
      'schemas' => $qualifiers,
    );
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue($value) {
    return $value instanceof InstanceValue
      ? $value->getEditorValue()
      : null;
  }

  /**
   * @inheritDoc
   */
  public function getSerializedValue($value) {
    return $value instanceof InstanceValue
      ? $value->getSerializedValue()
      : null;
  }

  /**
   * @inheritDoc
   */
  public function getValueRules() {
    return array_merge(
      [[InstanceValueValidator::class]],
      parent::getValueRules()
    );
  }

  /**
   * @param string $qualifier
   * @return bool
   * @throws Throwable
   */
  public function isValidSchema($qualifier) {
    $schemaManager = Plugin::getInstance()->schemas;

    foreach ($this->schemas as $schema) {
      $schemaInfo = $schemaManager->parseSchemaQualifier($schema);
      if (SchemaManager::isPattern($schemaInfo['name'])
        ? preg_match(SchemaManager::toPattern($schemaInfo['name']), $qualifier)
        : $qualifier == $schema
      ) {
        return true;
      }
    }

    return false;
  }

  /**
   * @inheritdoc
   */
  static function expandFieldConfig(&$config) {
    // Expand the type `instances` to an array of instance fields
    if ($config['type'] === 'instances') {
      $config = array_intersect_key($config, array(
        'collapsible' => true,
        'compact'     => true,
        'group'       => true,
        'name'        => true,
        'label'       => true,
        'limit'       => true,
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
