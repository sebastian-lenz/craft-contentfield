<?php

namespace lenz\contentfield\services\definitions;

use Exception;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\schemas\StructureSchema;
use lenz\contentfield\services\schemas\StructureLoader;

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
   * @param string $name
   * @return AbstractSchema|null
   * @throws Exception
   */
  public function getStructure($name) {
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
  protected function getDefinitionName() {
    return 'structures';
  }

  /**
   * @param string $type
   * @return boolean
   */
  protected function isNativeType($type) {
    return false;
  }

  /**
   * @return bool
   */
  protected function isTypeRequired() {
    return false;
  }

  /**
   * @param array $config
   * @param array $parent
   * @return array
   */
  protected function mergeDefinitions(array $config, array $parent) {
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
}
