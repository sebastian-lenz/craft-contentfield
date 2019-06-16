<?php

namespace lenz\contentfield\services\loaders;

use Throwable;
use lenz\contentfield\models\schemas\AbstractSchema;

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
    throw new Exception('Wildcard search is not supported by this loader.');
  }

  /**
   * Return a list of all available schemas.
   *
   * @return AbstractSchema[]
   */
  abstract function getAllSchemas();

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
