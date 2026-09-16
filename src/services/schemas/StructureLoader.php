<?php

namespace lenz\contentfield\services\schemas;

use Exception;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\schemas\Qualifier;
use lenz\contentfield\models\schemas\StructureSchema;
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
  public function findNames(string $pattern): array {
    [$schemas] = $this->getAllSchemas();
    $names = array_map(fn(StructureSchema $schema) => $schema->getName(), $schemas);

    return array_values(
      array_filter($names, fn($name) => preg_match($pattern, $name))
    );
  }

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
  public function load(Qualifier|string $qualifier): AbstractSchema {
    $qualifier = Qualifier::toQualifier($qualifier);
    $qualifier->name = $this->normalizeName($qualifier->name);

    if ($qualifier->scope) {
      $scope = Plugin::getInstance()->schemas->getSchema($qualifier->scope);
      if (is_null($scope)) {
        throw new Exception(sprintf('The scope `%s` does not exist.', $qualifier->scope));
      }

      $struct = $scope->getLocalStructure($qualifier->name);
      if (is_null($struct)) {
        throw new Exception(sprintf('The local structure `%s` does not exist in `%s`.', $qualifier->name, $scope->qualifier));
      }

      return $struct;
    }

    return Plugin::getInstance()->structures->getStructure($qualifier);
  }


  // Static methods
  // --------------

  /**
   * @param string $name
   * @param AbstractSchema|null $scope
   * @return Qualifier
   */
  static public function createQualifier(string $name, AbstractSchema $scope = null): Qualifier {
    return new Qualifier(
      name: $name,
      loader: self::NAME_PREFIX,
      scope: $scope ? Qualifier::toQualifier($scope) : null
    );
  }
}
