<?php

namespace lenz\contentfield\services\definitions;

use Exception;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\schemas\StructureSchema;
use lenz\contentfield\services\schemas\StructureLoader;
use Throwable;

/**
 * Class StructureDefinitions
 */
class StructureDefinitions extends AbstractDefinitions
{
  /**
   * @var StructureSchema[]
   */
  private $_structures = [];


  /**
   * @param array $config
   * @return array
   */
  public function expandDefinition(array $config): array {
    if (array_key_exists('type', $config)) {
      $parent = $this->getDefinition($config['type']);
      $config = $this->mergeDefinitions($config, $parent);
      unset($config['type']);
    }

    return $config;
  }

  /**
   * @return array
   */
  public function getAllStructures(): array {
    $this->loadDefinitions();

    return array_filter(
      array_map(function(string $name) {
        try {
          return $this->getStructure($name);
        } catch (Throwable $error) {
          return null;
        }
      }, array_keys($this->definitions))
    );
  }

  /**
   * @param string $name
   * @return StructureSchema|null
   * @throws Exception
   */
  public function getStructure(string $name): StructureSchema {
    if (!array_key_exists($name, $this->_structures)) {
      $definition = $this->resolveDefinition([
        'type' => $name
      ]);

      if (empty($definition)) {
        throw new Exception(sprintf('Could not find the structure `%s`.', $name));
      }

      unset($definition['type']);
      $this->_structures[$name] = new StructureSchema([
        'qualifier' => StructureLoader::createQualifier($name),
      ] + $definition);
    }

    return $this->_structures[$name];
  }


  // Protected methods
  // -----------------

  /**
   * @return string
   */
  protected function getDefinitionName(): string {
    return 'structures';
  }

  /**
   * @param string $type
   * @return boolean
   */
  protected function isNativeType(string $type): bool {
    return false;
  }

  /**
   * @return bool
   */
  protected function isTypeRequired(): bool {
    return false;
  }

  /**
   * @param array $config
   * @param array $parent
   * @return array
   */
  protected function mergeDefinitions(array $config, array $parent): array {
    if (
      array_key_exists('fields', $config) &&
      array_key_exists('fields', $parent)
    ) {
      $config['fields'] = array_merge(
        $parent['fields'],
        $config['fields']
      );
    }

    return array_merge($parent, $config);
  }


  // Static methods
  // --------------

  /**
   * @inheritDoc
   */
  static public function transformDefinitions(array $definitions): array {
    return array_map(function($definition) {
      try {
        return AbstractSchema::expandConfig($definition);
      } catch (Throwable $error) {
        return $definition;
      }
    }, $definitions);
  }
}
