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
  public function findNames(string $pattern): array {
    return [];
  }

  /**
   * Return a list of all available schemas.
   *
   * The returned array contains two child arrays, the first one
   * holds all loaded schemas, the second one a list of errors found
   * while loading the schemas.
   *
   * @return array
   * @throws Exception
   */
  public function getAllSchemas(): array {
    return [[], []];
  }

  /**
   * Load the schema with the given name.
   *
   * @param string $name
   * @return AbstractSchema
   * @throws Throwable
   */
  abstract function load(string $name): AbstractSchema;

  /**
   * Normalize the given name.
   *
   * @param string $name
   * @return string
   */
  public function normalizeName(string $name): string {
    return $name;
  }
}
