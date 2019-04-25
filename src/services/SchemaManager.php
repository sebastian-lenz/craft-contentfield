<?php

namespace lenz\contentfield\services;

use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\services\loaders\AbstractLoader;
use lenz\contentfield\services\loaders\TemplateLoader;

/**
 * Class SchemaManager
 */
class SchemaManager
{
  /**
   * @var AbstractLoader[]
   */
  private $loaders;

  /**
   * @var AbstractSchema[]
   */
  private $schemas = array();

  /**
   * @var TemplateLoader
   */
  private $templateLoader;


  /**
   * SchemaManager constructor.
   * @throws \yii\base\Exception
   */
  public function __construct() {
    $this->templateLoader = new TemplateLoader();
    $this->loaders = array(
      TemplateLoader::NAME_PREFIX => $this->templateLoader
    );
  }

  /**
   * @param mixed $data
   * @param ValueInterface|null $parent
   * @param InstanceField|null $field
   * @return InstanceValue
   * @throws \Exception
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
   * @throws \Exception
   */
  public function getSchema($qualifier) {
    $parsed = is_array($qualifier)
      ? $qualifier
      : $this->parseSchemaQualifier($qualifier);

    if (array_key_exists($parsed['uri'], $this->schemas)) {
      return $this->schemas[$parsed['uri']];
    }

    $schema = $parsed['loader']->load($parsed['name']);
    $this->schemas[$parsed['uri']] = $schema;
    return $schema;
  }

  /**
   * Returns a list of schemas.
   * Supports wildcards in qualifier names.
   *
   * @param string[] $qualifiers
   * @return AbstractSchema[]
   * @throws \Exception
   */
  public function getSchemas($qualifiers) {
    $result = array();
    foreach ($qualifiers as $qualifier) {
      $schemas = strpos($qualifier, '*') === false
        ? array($this->getSchema($qualifier))
        : $this->getSchemasWithWildcard($qualifier);

      foreach ($schemas as $schema) {
        if (!in_array($schema, $result)) {
          $result[] = $schema;
        }
      }
    }

    return $result;
  }

  /**
   * @param string $qualifier
   * @return AbstractSchema[]
   * @throws \Exception
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

  /**
   * Return the template loader instance.
   *
   * @return TemplateLoader
   */
  public function getTemplateLoader() {
    return $this->templateLoader;
  }

  /**
   * @param string $qualifier
   * @return array
   * @throws \Exception
   */
  public function parseSchemaQualifier($qualifier) {
    $divider = strpos($qualifier, ':');
    if ($divider === false) {
      return array(
        'loader' => $this->templateLoader,
        'name'   => $qualifier,
        'uri'    => TemplateLoader::NAME_PREFIX . $qualifier,
      );
    }

    $loaderName = substr($qualifier, 0, $divider + 1);
    if (!array_key_exists($loaderName, $this->loaders)) {
      throw new \Exception('Invalid schema name "' . $qualifier . '"');
    }

    $loader = $this->loaders[$loaderName];
    $name   = $loader->normalizeName(substr($qualifier, $divider + 1));
    $uri    = $loader::NAME_PREFIX . $name;

    return array(
      'loader' => $loader,
      'name'   => $name,
      'uri'    => $uri,
    );
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
