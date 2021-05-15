<?php

namespace lenz\contentfield\models\schemas;

use Exception;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\Plugin;
use lenz\contentfield\services\definitions\StructureDefinitions;

/**
 * Class StructureSchema
 */
class StructureSchema extends AbstractSchema
{
  /**
   * @var AbstractSchemaContainer|null
   */
  private $_container = null;


  /**
   * @inheritDoc
   */
  public function __construct(array $config = []) {
    if (isset($config['container'])) {
      $this->_container = $config['container'];
      unset($config['container']);
    }

    parent::__construct($config);
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function applyPageTemplate(BeforeActionEvent $event, Content $content) {
    throw new Exception('Pure data structures cannot be rendered.');
  }

  /**
   * @param string $name
   * @return AbstractSchema|null
   * @throws Exception
   */
  public function getLocalStructure(string $name): ?AbstractSchema {
    return is_null($this->_container)
      ? $this->getManager()->getStructure($name)
      : $this->_container->getLocalStructure($name);
  }

  /**
   * @param string $name
   * @return bool
   */
  public function hasLocalStructure(string $name): bool {
    return is_null($this->_container)
      ? $this->getManager()->hasDefinition($name)
      : $this->_container->hasLocalStructure($name);
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function render(InstanceValue $instance, array $variables = [], array $options = []): string {
    throw new Exception('Structures cannot be rendered or displayed.');
  }


  // Protected methods
  // -----------------

  /**
   * @return StructureDefinitions
   */
  protected function getManager() {
    return Plugin::getInstance()->structures;
  }
}
