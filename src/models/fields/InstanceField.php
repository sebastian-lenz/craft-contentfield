<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use Exception;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\models\values\ValueInterface;
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
  public bool $collapsible = false;

  /**
   * The name of the default schema which will be created if the instance
   * is empty. When not provided the first schema from the list of available
   * schemas will be used.
   *
   * @var string|null
   */
  public ?string $defaultSchema = null;

  /**
   * @var string|string[]|null
   */
  public string|array|null $excludes = null;

  /**
   * @var string[]
   */
  public array $includes = [];

  /**
   * The list of allowed schemas. Supports wildcards.
   *
   * @var string[]
   */
  public array $schemas = [];

  /**
   * @var AbstractSchema|null
   */
  private ?AbstractSchema $_parentSchema;

  /**
   * @var AbstractSchema[]
   */
  private array $_resolvedSchemas;

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

    foreach (['includes', 'schemas'] as $name) {
      if (array_key_exists($name, $config)) {
        $config[$name] = is_array($config[$name])
          ? $config[$name]
          : explode(',', $config[$name]);
      }
    }

    parent::__construct($schema, $config);
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function createValue(mixed $data, ValueInterface $parent = null): ?InstanceValue {
    if (count($this->schemas) === 0) {
      return null;
    }

    if (!is_array($data)) {
      $data = [];
    }

    $schema = $data[InstanceValue::TYPE_PROPERTY] ?? null;

    if (is_null($schema) || !$this->isValidSchema($schema)) {
      $defaultSchema = $this->getDefaultSchema();
      $data[InstanceValue::TYPE_PROPERTY] = $defaultSchema->qualifier;
    }

    return Plugin::getInstance()->schemas->createValue($data, $parent, $this);
  }

  /**
   * @return AbstractSchema
   * @throws Throwable
   */
  public function getDefaultSchema(): AbstractSchema {
    $defaultSchema = $this->defaultSchema;
    $schemas = $this->getResolvedSchemas();

    if (!empty($defaultSchema)) {
      foreach ($schemas as $schema) {
        if ($schema->matchesQualifier($defaultSchema)) {
          return $schema;
        }
      }
    }

    $schema = reset($schemas);
    if (!$schema) {
      throw new Exception(sprintf('No schema available on field `%s`.', $this->name));
    }

    return $schema;
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function getDependedSchemas(): array {
    $schemas = $this->getResolvedSchemas();
    $result = $schemas;

    foreach ($schemas as $schema) {
      $result += $schema->getDependedSchemas();
    }

    return $result;
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function getEditorData(ElementInterface $element = null): ?array {
    $qualifiers = array_keys($this->getResolvedSchemas());
    if (count($qualifiers) === 0) {
      return null;
    }

    return parent::getEditorData($element) + [
      'collapsible'   => !!$this->collapsible,
      'defaultSchema' => $this->getDefaultSchema()->qualifier,
      'schemas'       => $qualifiers,
    ];
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue(mixed $value): ?array {
    return $value instanceof InstanceValue
      ? $value->getEditorValue()
      : null;
  }

  /**
   * @return AbstractSchema[]
   * @throws Throwable
   * @internal
   */
  public function getResolvedSchemas(): array {
    if (!isset($this->_resolvedSchemas)) {
      $manager = Plugin::getInstance()->schemas;
      $parent = $this->_parentSchema;

      $schemas = $manager->getSchemas(
        array_map(
          function($schema) use ($parent, $manager) {
            return $manager->parseSchemaQualifier($schema, $parent);
          },
          array_merge($this->schemas, $this->includes)
        )
      );

      if (isset($this->excludes)) {
        $schemas = array_filter($schemas, function(AbstractSchema $schema) {
          return !$schema->matchesQualifier($this->excludes);
        });
      }

      $this->_resolvedSchemas = $schemas;
    }

    return $this->_resolvedSchemas;
  }

  /**
   * @param mixed $value
   * @return string
   */
  public function getSearchKeywords(mixed $value): string {
    if (!($value instanceof InstanceValue)) {
      return '';
    }

    return $value->getSearchKeywords();
  }

  /**
   * @inheritDoc
   */
  public function getSerializedValue(mixed $value, ElementInterface $element = null): ?array {
    return $value instanceof InstanceValue
      ? $value->getSerializedValue($element)
      : null;
  }

  /**
   * @inheritDoc
   */
  public function getValueRules(): array {
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
  public function isValidSchema(string $qualifier): bool {
    foreach ($this->getResolvedSchemas() as $schema) {
      if ($schema->matchesQualifier($qualifier)) {
        return true;
      }
    }

    return false;
  }

  /**
   * @inheritDoc
   */
  public function rules(): array {
    return array_merge(parent::rules(), [
      ['collapsible', 'boolean'],
      ['defaultSchema', 'string'],
      ['schemas', 'validateSchemas'],
    ]);
  }

  /**
   * @param string $attribute
   * @noinspection PhpUnused (Validator)
   */
  public function validateSchemas(string $attribute) {
    try {
      $schemas = $this->getResolvedSchemas();
      if (count($schemas) < 1) {
        $this->addError($attribute, 'An instance field must accept at least one valid schema.');
      }
    } catch (Throwable $error) {
      $this->addError($attribute, sprintf(
        'The schemas of the instance field could not be resolved: %s',
        $error->getMessage()
      ));
    }
  }


  // Static methods
  // --------------

  /**
   * @inheritdoc
   */
  static public function expandFieldConfig(array &$config): void {
    // Expand the type `instances` to an array of instance fields
    if ($config['type'] === 'instances') {
      $member = array_merge([
        'type'     => self::NAME,
      ], array_intersect_key($config, [
        'excludes' => true,
        'includes' => true,
        'name'     => true,
        'schemas'  => true,
      ]));

      $config = array_merge([
        'type'        => ArrayField::NAME,
        'member'      => $member,
      ], array_intersect_key($config, [
        'collapsible' => true,
        'group'       => true,
        'label'       => true,
        'limit'       => true,
        'name'        => true,
        'previewMode' => true,
        'style'       => true,
        'width'       => true,
      ]));
    }
  }
}
