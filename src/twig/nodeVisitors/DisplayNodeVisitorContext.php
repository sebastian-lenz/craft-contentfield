<?php

namespace lenz\contentfield\twig\nodeVisitors;

use Craft;
use lenz\contentfield\models\schemas\TemplateSchema;
use lenz\contentfield\twig\nodes\InlineIndexNode;
use lenz\contentfield\twig\nodes\InlineTemplateNode;
use Throwable;
use Twig\Environment;
use Twig\Node\ModuleNode;

/**
 * Class DisplayNodeVisitorContext
 */
class DisplayNodeVisitorContext
{
  /**
   * @var InlineIndexNode
   */
  private $_indexNode;

  /**
   * @var bool
   */
  private $_isInlining = false;

  /**
   * @var array
   */
  private $_inlineDependencies = [];

  /**
   * @var bool
   */
  private $_inlineRequiresIndex = false;

  /**
   * @var ModuleNode
   */
  private $_module;

  /**
   * @var DisplayNodeVisitorContext|null
   */
  private $_parent;

  /**
   * @var bool
   */
  private $_requiresIndex = false;

  /**
   * A list of recorded inline information, indexed by schema qualifier.
   * @var array
   */
  static private $_inlineCache = [];

  /**
   * A list of all already compiled modules, indexed by template path.
   * @var ModuleNode[]
   */
  static private $_compiledModules = [];


  /**
   * DisplayNodeVisitorContext constructor.
   *
   * @param ModuleNode $module
   * @param DisplayNodeVisitorContext|null $parent
   */
  public function __construct(ModuleNode $module, DisplayNodeVisitorContext $parent = null) {
    $this->_module = $module;
    $this->_parent = $parent;
  }

  /**
   * Retrieves the twig module this context stands for.
   *
   * @return ModuleNode
   */
  public function getModule() {
    return $this->_module;
  }

  /**
   * Retrieves the parent module context.
   *
   * @return DisplayNodeVisitorContext|null
   */
  public function getParent() {
    return $this->_parent;
  }

  /**
   * Requires the index node within the current context.
   *
   * This means that a node requires the method `contentfieldDisplay`
   * to be present in the compiled template.
   */
  public function requireIndex() {
    // If we are inlining, record the index requirement
    if ($this->_isInlining) {
      $this->_inlineRequiresIndex = true;
    }

    // If the parent is inlining, delegate this call to the parent
    if (!is_null($this->_parent) && $this->_parent->_isInlining) {
      $this->_parent->requireIndex();
    }

    // Otherwise mark the index as required on this context
    elseif (!$this->_requiresIndex) {
      $this->_requiresIndex = true;
      $this->_module
        ->getNode('class_end')
        ->setNode('inline_index', $this->getIndexNode());
    }
  }

  /**
   * Tries to inline another schema within the current context.
   *
   * @param TemplateSchema $schema
   * @param Environment $env
   * @return string|null
   */
  public function tryInline(TemplateSchema $schema, Environment $env) {
    if ($this->_isInlining) {
      $this->addDependency($schema);
      return $this->inline($schema, $env);
    }

    $this->_isInlining = true;

    if (!array_key_exists($schema->qualifier, self::$_inlineCache)) {
      $this->_inlineDependencies  = [];
      $this->_inlineRequiresIndex = false;
      $callback = $this->inline($schema, $env);

      if (is_null($callback)) {
        self::$_inlineCache[$schema->qualifier] = null;
      } else {
        self::$_inlineCache[$schema->qualifier] = [
          'dependencies'  => $this->_inlineDependencies,
          'requiresIndex' => $this->_inlineRequiresIndex,
          'schema'        => $schema,
        ];
      }
    } else {
      $callback = $this->inline($schema, $env);
    }

    $this->_isInlining = false;
    return $callback;
  }


  // Private methods
  // ---------------

  /**
   * @param TemplateSchema $schema
   */
  private function addDependency(TemplateSchema $schema) {
    if (!$this->_isInlining) {
      return;
    }

    if (!in_array($schema, $this->_inlineDependencies, true)) {
      $this->_inlineDependencies[] = $schema;
    }

    if (!is_null($this->_parent)) {
      $this->_parent->addDependency($schema);
    }
  }

  /**
   * Compiles a schema to a twig module.
   *
   * @param TemplateSchema $schema
   * @param Environment $env
   * @return ModuleNode|null
   */
  private function compile(TemplateSchema $schema, Environment $env) {
    $template = $schema->template;

    if (!isset(self::$_compiledModules[$template])) {
      $module = null;
      try {
        $source = $env->getLoader()->getSourceContext($schema->template);
        $module = $env->parse($env->tokenize($source));
      } catch (Throwable $error) {
        Craft::error($error->getMessage());
      }

      self::$_compiledModules[$template] = $module;
    }

    return self::$_compiledModules[$template];
  }

  /**
   * @param TemplateSchema $schema
   * @param Environment $env
   * @return string|null
   */
  private function inline(TemplateSchema $schema, Environment $env) {
    // If the parent is inlining, delegate this call to the parent
    if (
      !is_null($this->_parent) &&
      $this->_parent->_isInlining
    ) {
      return $this->_parent->tryInline($schema, $env);
    }

    // Check whether we already have that template inlined
    $callback = $this->getIndexNode()->getInlinedSchema($schema->qualifier);
    if (!is_null($callback)) {
      return $callback;
    }

    // If we have cached information about that schema, use it
    if (array_key_exists($schema->qualifier, self::$_inlineCache)) {
      return $this->inlineCached(self::$_inlineCache[$schema->qualifier], $env);
    }

    // Finally, we have to compile that template
    return $this->inlineCompile($schema, $env);
  }

  /**
   * Inlines a schema by compiling it.
   *
   * @param TemplateSchema $schema
   * @param Environment $env
   * @return string|null
   */
  private function inlineCompile(TemplateSchema $schema, Environment $env) {
    $module = $this->compile($schema, $env);

    return is_null($module)
      ? null
      : $this->inlineModule($schema, $module);
  }

  /**
   * Inlines a compiled twig module. Returns the name of the render
   * function.
   *
   * @param TemplateSchema $schema
   * @param ModuleNode $module
   * @return string
   */
  private function inlineModule(TemplateSchema $schema, ModuleNode $module) {
    // Check whether the module is already present
    $classEnd = $this->_module->getNode('class_end');
    if ($classEnd->hasNode($schema->qualifier)) {
      return $classEnd
        ->getNode($schema->qualifier)
        ->getAttribute('name');
    }

    // Copy over all macros
    $rootMacros = $this->_module->getNode('macros');
    foreach ($module->getNode('macros') as $name => $macroNode) {
      $rootMacros->setNode($name, $macroNode);
    }

    // Copy over macro imports
    $constructorEnd = $this->_module->getNode('constructor_end');
    foreach ($module->getNode('constructor_end') as $name => $constructorEndNode) {
      $constructorEnd->setNode($name, $constructorEndNode);
    }

    // Create an inline template node
    $node     = new InlineTemplateNode($schema, $module);
    $callback = $node->getAttribute('name');
    $classEnd->setNode($schema->qualifier, $node);

    // Register the inline at the index node
    $this->getIndexNode()
      ->setInlinedSchema($schema->qualifier, $callback);

    return $callback;
  }

  /**
   * Inlines a cached record.
   *
   * @param array|null $config
   * @param Environment $env
   * @return string|null
   */
  private function inlineCached($config, Environment $env) {
    if (!is_array($config)) {
      return null;
    }

    if ($config['requiresIndex']) {
      $this->requireIndex();
    }

    foreach ($config['dependencies'] as $dependency) {
      $this->addDependency($dependency);
      $this->inlineCompile($dependency, $env);
    }

    return $this->inlineCompile($config['schema'], $env);
  }

  /**
   * @return InlineIndexNode
   */
  private function getIndexNode() {
    if (is_null($this->_indexNode)) {
      $this->_indexNode = new InlineIndexNode();
    }

    return $this->_indexNode;
  }
}
