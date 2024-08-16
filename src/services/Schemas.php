<?php

namespace lenz\contentfield\services;

use craft\web\twig\TemplateLoaderException;
use Exception;
use lenz\contentfield\exceptions\ContentLoadException;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\services\schemas\AbstractLoader;
use lenz\contentfield\services\schemas\StructureLoader;
use lenz\contentfield\services\schemas\TemplateLoader;
use Throwable;

/**
 * Class Schemas
 */
class Schemas
{
  /**
   * @var Exception[]
   */
  private array $_allErrors;

  /**
   * @var AbstractSchema[]
   */
  private array $_allSchemas;

  /**
   * @var AbstractLoader[]
   */
  private array $_loaders;

  /**
   * @var AbstractSchema[]
   */
  private array $_schemas = [];

  /**
   * @var StructureLoader
   */
  private StructureLoader $_structureLoader;

  /**
   * @var TemplateLoader
   */
  private TemplateLoader $_templateLoader;


  /**
   * SchemaManager constructor.
   * @throws Throwable
   */
  public function __construct() {
    $this->_structureLoader = new StructureLoader();
    $this->_templateLoader = new TemplateLoader();
    $this->_loaders = [
      StructureLoader::NAME_PREFIX => $this->_structureLoader,
      TemplateLoader::NAME_PREFIX  => $this->_templateLoader,
    ];
  }

  /**
   * @param mixed $data
   * @param ValueInterface|null $parent
   * @param InstanceField|null $field
   * @return InstanceValue|null
   * @throws ContentLoadException
   * @throws Exception
   */
  public function createValue(mixed $data, ValueInterface $parent = null, InstanceField $field = null, Content $content = null): ?InstanceValue {
    if (!is_array($data) || !isset($data[InstanceValue::TYPE_PROPERTY])) {
      return null;
    }

    try {
      $schema = $this->getSchema($data[InstanceValue::TYPE_PROPERTY]);
    } catch (TemplateLoaderException $exception) {
      throw new ContentLoadException($exception->getMessage());
    }

    if (is_null($schema)) {
      return null;
    }

    return new InstanceValue($data, $schema, $parent, $field);
  }

  /**
   * @return Exception[]
   * @throws Exception
   */
  public function getAllErrors(): array {
    if (!isset($this->_allErrors)) {
      $this->getAllSchemas();
    }

    return $this->_allErrors;
  }

  /**
   * @return AbstractSchema[]
   * @throws Exception
   */
  public function getAllSchemas(): array {
    if (!isset($this->_allSchemas)) {
      $errors  = [];
      $schemas = [];

      foreach ($this->_loaders as $loader) {
        list($loaderSchemas, $loaderErrors) = $loader->getAllSchemas();
        $errors  = array_merge($errors, $loaderErrors);
        $schemas = array_merge($schemas, $loaderSchemas);
      }

      $this->_allErrors  = $errors;
      $this->_allSchemas = $schemas;
    }

    return $this->_allSchemas;
  }

  /**
   * @param AbstractSchema[] $schemas
   * @return AbstractSchema[]
   */
  public function getDependedSchemas(array $schemas): array {
    $result = [];
    $stack  = $schemas;

    while ($schema = array_pop($stack)) {
      $result[$schema->qualifier] = $schema;
      $children = $schema->getDependedSchemas();

      foreach ($children as $qualifier => $child) {
        if (array_key_exists($qualifier, $result)) {
          continue;
        } else if (!array_key_exists($qualifier, $stack)) {
          $stack[$qualifier] = $child;
        }
      }
    }

    return $result;
  }

  /**
   * Returns a schema by its name.
   *
   * @param array|string $qualifier
   * @return null|AbstractSchema
   * @throws Exception
   */
  public function getSchema(array|string $qualifier): ?AbstractSchema {
    $parsed = is_array($qualifier)
      ? $qualifier
      : $this->parseSchemaQualifier($qualifier);

    if (array_key_exists($parsed['uri'], $this->_schemas)) {
      return $this->_schemas[$parsed['uri']];
    }

    $schema = $parsed['loader']->load($parsed['name']);
    $this->_schemas[$parsed['uri']] = $schema;
    return $schema;
  }

  /**
   * Returns a list of schemas.
   * Supports wildcards in qualifier names.
   *
   * @param array $qualifiers
   * @return AbstractSchema[]
   * @throws Throwable
   */
  public function getSchemas(array $qualifiers): array {
    $result = [];

    foreach ($qualifiers as $qualifier) {
      $schemas = self::isPattern($qualifier)
        ? $this->getSchemasWithWildcard($qualifier)
        : [$this->getSchema($qualifier)];

      foreach ($schemas as $schema) {
        $result[$schema->qualifier] = $schema;
      }
    }

    return $result;
  }

  /**
   * Return the structure loader instance.
   *
   * @return StructureLoader
   * @noinspection PhpUnused
   */
  public function getStructureLoader(): StructureLoader {
    return $this->_structureLoader;
  }

  /**
   * Return the template loader instance.
   *
   * @return TemplateLoader
   */
  public function getTemplateLoader(): TemplateLoader {
    return $this->_templateLoader;
  }

  /**
   * Tests whether the given qualifier matches any of the given specs.
   *
   * @param string $qualifier
   * @param string|string[] $specs
   * @param AbstractSchema|null $scope
   * @return bool
   * @throws Exception
   */
  public function matchesQualifier(string $qualifier, array|string $specs, AbstractSchema $scope = null): bool {
    $qualifierInfo = $this->parseSchemaQualifier($qualifier, $scope);

    if (!is_array($specs)) {
      $specs = [$specs];
    }

    foreach ($specs as $spec) {
      $schemaInfo = $this->parseSchemaQualifier($spec, $scope);

      if ($qualifierInfo['uri'] == $schemaInfo['uri']) {
        return true;
      } else if (
        $schemaInfo['loader'] == $qualifierInfo['loader'] &&
        Schemas::isPattern($schemaInfo['name']) &&
        preg_match(Schemas::toPattern($schemaInfo['name']), $qualifierInfo['name'])
      ) {
        return true;
      }
    }

    return false;
  }

  /**
   * @param string $qualifier
   * @param AbstractSchema|null $scope
   * @return array
   * @throws Exception
   */
  public function parseSchemaQualifier(string $qualifier, AbstractSchema $scope = null): array {
    $divider = strpos($qualifier, ':');
    $name = $divider === false
      ? trim($qualifier)
      : trim(substr($qualifier, $divider + 1));

    // Check if the name is a local structure
    if (
      !is_null($scope) &&
      $scope->hasLocalStructure($name)
    ) {
      $name = $this->_structureLoader->normalizeName($name);
      return [
        'loader' => $this->_structureLoader,
        'name' => StructureLoader::createName($name, $scope),
        'uri' => StructureLoader::createQualifier($name, $scope),
      ];
    }

    // If no loader is given, assume it is a template
    if ($divider === false) {
      $loader = $this->_templateLoader;

    // Otherwise, delegate to the loader
    } else {
      $loaderName = substr($qualifier, 0, $divider + 1);
      if (!array_key_exists($loaderName, $this->_loaders)) {
        throw new Exception('Invalid schema name "' . $qualifier . '"');
      }

      $loader = $this->_loaders[$loaderName];
    }

    $name = $loader->normalizeName($name);
    return [
      'loader' => $loader,
      'name' => $name,
      'uri' => $loader::NAME_PREFIX . $name,
    ];
  }


  // Private methods
  // ---------------

  /**
   * @param array|string $qualifier
   * @return AbstractSchema[]
   * @throws Throwable
   */
  private function getSchemasWithWildcard(array|string $qualifier): array {
    $parsed = is_array($qualifier)
      ? $qualifier
      : $this->parseSchemaQualifier($qualifier);

    /** @var AbstractLoader $loader */
    $loader = $parsed['loader'];
    $names  = $loader->findNames(self::toPattern($parsed['name']));
    $result = [];

    foreach ($names as $name) {
      $result[] = $this->getSchema([
        'loader' => $loader,
        'name'   => $name,
        'uri'    => $loader::NAME_PREFIX . $name,
      ]);
    }

    return $result;
  }


  // Static methods
  // --------------

  /**
   * @param array|string $value
   * @return bool
   */
  static public function isPattern(array|string $value): bool {
    $name = is_array($value) ? $value['name'] : $value;

    return (
      str_contains($name, '*') ||
      (str_starts_with($name, '/') && str_ends_with($name, '/'))
    );
  }

  /**
   * @param string $value
   * @return string
   */
  static function toPattern(string $value): string {
    if (str_starts_with($value, '/') && str_ends_with($value, '/')) {
      return $value;
    }

    $pattern = implode('[A-Za-z0-9-_]+', array_map(function($part) {
      return preg_quote($part, '/');
    }, explode('*', $value)));

    return '/^' . $pattern . '$/';
  }
}
