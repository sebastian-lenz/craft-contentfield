<?php

namespace lenz\contentfield\services\schemas;

use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\Plugin;

/**
 * Class StructureLoader
 */
class StructureLoader extends AbstractLoader
{
  /**
   * Prefix for the schema names loaded by this loader.
   */
  const NAME_PREFIX = 'structure:';


  /**
   * @inheritDoc
   */
  public function load($name) {
    $schemaOffset = strpos($name, '@');
    if ($schemaOffset !== false) {
      $schemaName = substr($name, $schemaOffset + 1);
      $schema = Plugin::getInstance()->schemas->getSchema($schemaName);

      return $schema->getLocalStructure(substr($name, 0, $schemaOffset));
    }

    return Plugin::getInstance()->structures->getStructure($name);
  }


  // Static methods
  // --------------

  /**
   * @param string $name
   * @param AbstractSchema|null $scope
   * @return string
   */
  public static function createName($name, AbstractSchema $scope = null) {
    return is_null($scope)
      ? $name
      : $name . '@' . $scope->qualifier;
  }

  /**
   * @param string $name
   * @param AbstractSchema|null $scope
   * @return string
   */
  static public function createQualifier($name, AbstractSchema $scope = null) {
    return self::NAME_PREFIX . self::createName($name, $scope);
  }
}
