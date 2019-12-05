<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use Exception;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\Plugin;
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
   * Whether the instance can be expanded / collapsed or not.
   *
   * @var boolean
   */
  public $collapsible = false;

  /**
   * The list of allowed schemas. Supports wildcards.
   *
   * @var string[]
   */
  public $schemas;

  /**
   * @var AbstractSchema|null
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
   * InstanceField constructor.
   *
   * @param AbstractSchema|null $schema
   * @param array $config
   * @throws Throwable
   */
  public function __construct(AbstractSchema $schema = null, array $config = []) {
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
  public function createValue($data, ValueInterface $parent = null) {
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
      $schemas = $this->getResolvedSchemas();
      $defaultSchema = reset($schemas);
      if (!$defaultSchema) {
        throw new Exception(sprintf('No schema available on field `%s`.', $this->name));
      }

      $data[InstanceValue::TYPE_PROPERTY] = $defaultSchema->qualifier;
    }

    return Plugin::getInstance()->schemas->createValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function getDependedSchemas() {
    $schemas = $this->getResolvedSchemas();
    $result  = $schemas;

    foreach ($schemas as $schema) {
      $dependencies = $schema->getDependedSchemas();
      if (!is_null($dependencies)) {
        $result += $dependencies;
      }
    }

    return $result;
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function getEditorData(ElementInterface $element = null) {
    $qualifiers = array_keys($this->getResolvedSchemas());
    if (count($qualifiers) === 0) {
      return null;
    }

    return parent::getEditorData($element) + array(
      'collapsible' => !!$this->collapsible,
      'schemas'     => $qualifiers,
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
   * @return AbstractSchema[]
   * @throws Throwable
   * @internal
   */
  public function getResolvedSchemas() {
    if (!isset($this->_resolvedSchemas)) {
      $manager = Plugin::getInstance()->schemas;
      $parent  = $this->_parentSchema;

      $this->_resolvedSchemas = $manager->getSchemas(
        array_map(
          function($schema) use ($parent, $manager) {
            return $manager->parseSchemaQualifier($schema, $parent);
          },
          $this->schemas
        )
      );
    }

    return $this->_resolvedSchemas;
  }

  /**
   * @param mixed $value
   * @return string
   */
  public function getSearchKeywords($value) {
    if (!($value instanceof InstanceValue)) {
      return '';
    }

    return $value->getSearchKeywords();
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
    return Plugin::getInstance()
      ->schemas
      ->matchesQualifier($qualifier, $this->schemas, $this->_parentSchema);
  }


  // Static methods
  // --------------

  /**
   * @inheritdoc
   */
  static public function expandFieldConfig(&$config) {
    // Expand the type `instances` to an array of instance fields
    if ($config['type'] === 'instances') {
      $config = array_intersect_key($config, array(
        'collapsible' => true,
        'group'       => true,
        'label'       => true,
        'limit'       => true,
        'name'        => true,
        'previewMode' => true,
        'style'       => true,
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
