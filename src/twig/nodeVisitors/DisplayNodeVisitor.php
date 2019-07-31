<?php

namespace lenz\contentfield\twig\nodeVisitors;

use Exception;
use lenz\contentfield\models\schemas\TemplateSchema;
use lenz\contentfield\twig\nodes\DisplayNode;
use lenz\contentfield\twig\nodes\InlineIndexNode;
use lenz\contentfield\twig\nodes\InlineTemplateNode;
use lenz\contentfield\twig\nodes\SiblingsNode;
use Throwable;
use Twig\Environment;
use Twig\Error\Error;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Node\ModuleNode;
use Twig\Node\Node;
use Twig\NodeVisitor\AbstractNodeVisitor;

/**
 * Class DisplayNodeVisitor
 */
class DisplayNodeVisitor extends AbstractNodeVisitor
{
  /**
   * @var InlineIndexNode
   */
  private $_inlineIndex;

  /**
   * @var ModuleNode[]
   */
  private $_moduleStack = [];

  /**
   * @var bool
   */
  private $_requiresIndex = false;

  /**
   * @var ModuleNode[]
   */
  static private $_templates = [];


  /**
   * @inheritDoc
   * @throws Throwable
   */
  protected function doEnterNode(Node $node, Environment $env) {
    if ($node instanceof ModuleNode) {
      $this->_moduleStack[] = $node;
      if (count($this->_moduleStack) == 1) {
        $this->_inlineIndex = new InlineIndexNode();
        $this->_requiresIndex = false;
      }
    } elseif ($node instanceof DisplayNode) {
      $this->attach($node, $env);
    } else if ($node instanceof SiblingsNode) {
      $this->_requiresIndex = true;
    }

    return $node;
  }

  /**
   * @inheritDoc
   */
  protected function doLeaveNode(Node $node, Environment $env) {
    if ($node instanceof ModuleNode) {
      array_pop($this->_moduleStack);
      if (count($this->_moduleStack) == 0 && $this->_requiresIndex) {
        $node->getNode('class_end')->setNode('inline_index', $this->_inlineIndex);
      }
    }

    return $node;
  }

  /**
   * @inheritDoc
   */
  public function getPriority() {
    return 0;
  }


  // Protected methods
  // -----------------

  /**
   * @param DisplayNode $node
   * @param Environment $env
   * @throws Throwable
   */
  protected function attach(DisplayNode $node, Environment $env) {
    if ($node->usesIndexDisplay()) {
      $this->_requiresIndex = true;
    }

    foreach ($node->getInlineSchemaCandidates() as $candidate) {
      $callback = $this->tryInline($candidate, $env);

      if (!is_null($callback)) {
        $node->setInlinedSchema($candidate->qualifier, $callback);
        $this->_inlineIndex->setInlinedSchema($candidate->qualifier, $callback);
      }
    }
  }

  /**
   * @param TemplateSchema $schema
   * @param Environment $env
   * @return ModuleNode
   * @throws Error
   * @throws SyntaxError
   * @throws LoaderError
   */
  protected function compile(TemplateSchema $schema, Environment $env) {
    $template = $schema->template;
    if (!isset(self::$_templates[$template])) {
      $source = $env->getLoader()->getSourceContext($schema->template);

      try {
        self::$_templates[$template] = $env->parse($env->tokenize($source));
      } catch (Error $error) {
        $error->setSourceContext($source);
        throw $error;
      } catch (Exception $error) {
        throw new SyntaxError(
          sprintf(
            'An exception has been thrown during the compilation of a template ("%s").',
            $error->getMessage()
          ),
          -1,
          $source,
          $error
        );
      }
    }

    return self::$_templates[$template];
  }

  /**
   * @param TemplateSchema $schema
   * @param Environment $env
   * @return string|null
   * @throws Throwable
   */
  protected function tryInline(TemplateSchema $schema, Environment $env) {
    $root = reset($this->_moduleStack);
    if (!($root instanceof ModuleNode)) {
      return null;
    }

    // Check whether we already have that template inlined
    $classEnd = $root->getNode('class_end');
    if ($classEnd->hasNode($schema->qualifier)) {
      return $classEnd
        ->getNode($schema->qualifier)
        ->getAttribute('name');
    }

    // Compile the template
    $subModule = $this->compile($schema, $env);

    // Copy over all macros
    $rootMacros = $root->getNode('macros');
    foreach ($subModule->getNode('macros') as $name => $macroNode) {
      $rootMacros->setNode($name, $macroNode);
    }

    // Create an inline template node
    $node = new InlineTemplateNode($schema, $subModule);
    $classEnd->setNode($schema->qualifier, $node);

    return $node->getAttribute('name');
  }
}
