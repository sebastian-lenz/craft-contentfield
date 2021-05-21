<?php

namespace lenz\contentfield\services\schemas;

use Exception;
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
   * @return array
   * @throws Exception
   */
  public function getAllSchemas(): array {
    return [Plugin::getInstance()->structures->getAllStructures(), []];
  }

  /**
   * @inheritDoc
   */
  public function load(string $name): AbstractSchema {
    $schemaOffset = strpos($name, '@');
    if ($schemaOffset !== false) {
      $schemaName = substr($name, $schemaOffset + 1);
      $schema = Plugin::getInstance()->schemas->getSchema($schemaName);

      $structName = substr($name, 0, $schemaOffset);
      $struct = $schema->getLocalStructure($structName);

      if (is_null($struct)) {
        throw new Exception(printf('The local structure `%s` does not exist in `%s`.', $structName, $schemaName));
      }

      return $struct;
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
  public static function createName(string $name, AbstractSchema $scope = null): string {
    return is_null($scope)
      ? $name
      : $name . '@' . $scope->qualifier;
  }

  /**
   * @param string $name
   * @param AbstractSchema|null $scope
   * @return string
   */
  static public function createQualifier(string $name, AbstractSchema $scope = null): string {
    return self::NAME_PREFIX . self::createName($name, $scope);
  }
}
