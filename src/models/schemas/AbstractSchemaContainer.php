<?php

namespace lenz\contentfield\models\schemas;

use Exception;
use lenz\contentfield\Plugin;
use lenz\contentfield\services\schemas\StructureLoader;

/**
 * Class AbstractSchemaContainer
 */
abstract class AbstractSchemaContainer extends AbstractSchema
{
  /**
   * @var StructureSchema[]
   */
  private $_localStructures = [];


  /**
   * AbstractSchemaWithLocals constructor.
   * @param array $config
   * @throws Exception
   */
  public function __construct(array $config = []) {
    // Set the qualifier early as we'll need it to resolve local
    // structure qualifiers which must be resolved before we create fields
    if (!isset($config['qualifier'])) {
      throw new Exception('All schemas must have a qualifier.');
    } else {
      $this->qualifier = $config['qualifier'];
    }

    if (isset($config['structures'])) {
      foreach ($config['structures'] as $name => $schema) {
        $this->addLocalStructure($name, $schema);
      }

      unset($config['structures']);
    }

    parent::__construct($config);
  }

  /**
   * @param string $name
   * @return AbstractSchema|null
   */
  public function getLocalStructure($name) {
    return array_key_exists($name, $this->_localStructures)
      ? $this->_localStructures[$name]
      : null;
  }

  /**
   * @param string $name
   * @return bool
   */
  public function hasLocalStructure($name) {
    return array_key_exists($name, $this->_localStructures);
  }


  // Protected methods
  // -----------------

  /**
   * @param string $name
   * @param array $config
   * @return StructureSchema
   * @throws Exception
   */
  protected function addLocalStructure($name, $config) {
    if ($this->hasLocalStructure($name)) {
      throw new Exception(sprintf(
        'The local structure `%s` already exists in `%s`.',
        $name, $this->qualifier
      ));
    }

    $config = Plugin::getInstance()
      ->structures
      ->expandDefinition($config);

    $schema = new StructureSchema([
      'container' => $this,
      'qualifier' => StructureLoader::createQualifier($name, $this),
    ] + $config);

    $this->_localStructures[$name] = $schema;
    return $schema;
  }
}

