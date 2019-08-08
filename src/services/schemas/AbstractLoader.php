<?php

namespace lenz\contentfield\services\schemas;

use Exception;
use lenz\contentfield\models\schemas\AbstractSchema;
use Throwable;

/**
 * Class AbstractLoader
 *
 * Base class of all schema loaders.
 */
abstract class AbstractLoader
{
  /**
   * Prefix for the schema qualifiers loaded by this loader.
   */
  const NAME_PREFIX = 'unknown:';


  /**
   * Return a list of all available schema names.
   *
   * @param string $pattern
   * @return string[]
   * @throws Throwable
   */
  public function findNames($pattern) {
    return [];
  }

  /**
   * Return a list of all available schemas.
   *
   * The returned array contains to child arrays, the first one
   * holds all loaded schemas, the second one a list of errors found
   * while loading the schemas.
   *
   * @return array
   */
  public function getAllSchemas() {
    return [[], []];
  }

  /**
   * Load the schema with the given name.
   *
   * @param string $name
   * @return AbstractSchema
   * @throws Throwable
   */
  abstract function load($name);

  /**
   * Normalize the given name.
   *
   * @param string $name
   * @return string
   */
  public function normalizeName($name) {
    return $name;
  }
}
