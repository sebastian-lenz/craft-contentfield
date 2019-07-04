<?php

namespace lenz\contentfield\services;

use Exception;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\services\loaders\AbstractLoader;
use lenz\contentfield\services\loaders\StructureLoader;
use lenz\contentfield\services\loaders\TemplateLoader;
use Throwable;

/**
 * Class SchemaManager
 */
class SchemaManager
{
  /**
   * @var AbstractSchema[]
   */
  private $_allSchemas;

  /**
   * @var AbstractLoader[]
   */
  private $_loaders;

  /**
   * @var AbstractSchema[]
   */
  private $_schemas = array();

  /**
   * @var StructureLoader
   */
  private $_structureLoader;

  /**
   * @var TemplateLoader
   */
  private $_templateLoader;


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
   * @return InstanceValue
   * @throws Exception
   */
  public function createValue($data, ValueInterface $parent = null, InstanceField $field = null) {
    if (!is_array($data) || !isset($data[InstanceValue::TYPE_PROPERTY])) {
      return null;
    }

    $schema = $this->getSchema($data[InstanceValue::TYPE_PROPERTY]);
    if (is_null($schema)) {
      return null;
    }

    return new InstanceValue($data, $schema, $parent, $field);
  }

  /**
   * @return AbstractSchema[]
   */
  public function getAllSchemas() {
    if (!isset($this->_allSchemas)) {
      $schemas = [];
      foreach ($this->_loaders as $loader) {
        $schemas = array_merge($schemas, $loader->getAllSchemas());
      }

      $this->_allSchemas = $schemas;
    }

    return $this->_allSchemas;
  }

  /**
   * @param AbstractSchema[] $schemas
   * @return AbstractSchema[]
   */
  public function getDependedSchemas($schemas) {
    $result = array();
    $stack = $schemas;

    while ($schema = array_pop($stack)) {
      $result[$schema->qualifier] = $schema;
      $children = $schema->getDependedSchemas();

      foreach ($children as $child) {
        if (in_array($child, $result)) {
          continue;
        } else if (!in_array($child, $stack)) {
          $stack[] = $child;
        }
      }
    }

    return $result;
  }

  /**
   * Returns a schema by its name.
   *
   * @param string|array $qualifier
   * @return null|AbstractSchema
   * @throws Exception
   */
  public function getSchema($qualifier) {
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
   * @param string[] $qualifiers
   * @return AbstractSchema[]
   * @throws Throwable
   */
  public function getSchemas($qualifiers) {
    $result = array();
    foreach ($qualifiers as $qualifier) {
      $schemas = self::isPattern($qualifier)
        ? $this->getSchemasWithWildcard($qualifier)
        : array($this->getSchema($qualifier));

      foreach ($schemas as $schema) {
        if (!in_array($schema, $result)) {
          $result[] = $schema;
        }
      }
    }

    return $result;
  }

  /**
   * Return the structure loader instance.
   *
   * @return StructureLoader
   */
  public function getStructureLoader() {
    return $this->_structureLoader;
  }

  /**
   * Return the template loader instance.
   *
   * @return TemplateLoader
   */
  public function getTemplateLoader() {
    return $this->_templateLoader;
  }

  /**
   * @param string $qualifier
   * @return array
   * @throws Exception
   */
  public function parseSchemaQualifier($qualifier) {
    $divider = strpos($qualifier, ':');
    if ($divider === false) {
      return array(
        'loader' => $this->_templateLoader,
        'name'   => $qualifier,
        'uri'    => TemplateLoader::NAME_PREFIX . $qualifier,
      );
    }

    $loaderName = substr($qualifier, 0, $divider + 1);
    if (!array_key_exists($loaderName, $this->_loaders)) {
      throw new Exception('Invalid schema name "' . $qualifier . '"');
    }

    $loader = $this->_loaders[$loaderName];
    $name   = $loader->normalizeName(substr($qualifier, $divider + 1));
    $uri    = $loader::NAME_PREFIX . $name;

    return array(
      'loader' => $loader,
      'name'   => $name,
      'uri'    => $uri,
    );
  }


  // Private methods
  // ---------------

  /**
   * @param string $qualifier
   * @return AbstractSchema[]
   * @throws Throwable
   */
  private function getSchemasWithWildcard($qualifier) {
    $parsed = $this->parseSchemaQualifier($qualifier);

    /** @var AbstractLoader $loader */
    $loader = $parsed['loader'];
    $names  = $loader->findNames(self::toPattern($parsed['name']));
    $result = array();

    foreach ($names as $name) {
      $result[] = $this->getSchema(array(
        'loader' => $loader,
        'name'   => $name,
        'uri'    => $loader::NAME_PREFIX . $name,
      ));
    }

    return $result;
  }


  // Static methods
  // --------------

  /**
   * @param string $value
   * @return bool
   */
  static public function isPattern($value) {
    return strpos($value, '*') !== false;
  }

  /**
   * @param string $value
   * @return string
   */
  static function toPattern($value) {
    $pattern = implode('[A-Za-z0-9-_]+', array_map(function($part) {
      return preg_quote($part, '/');
    }, explode('*', $value)));

    return '/' . $pattern . '/';
  }
}
