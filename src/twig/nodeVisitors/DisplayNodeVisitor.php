<?php

namespace lenz\contentfield\twig\nodeVisitors;

use Exception;
use lenz\contentfield\models\schemas\TemplateSchema;
use lenz\contentfield\twig\nodes\DisplayNode;
use lenz\contentfield\twig\nodes\InlineTemplateNode;
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
   * @var ModuleNode[]
   */
  private $_moduleStack = [];

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
    } elseif ($node instanceof DisplayNode) {
      $this->attach($node, $env);
    }

    return $node;
  }

  /**
   * @inheritDoc
   */
  protected function doLeaveNode(Node $node, Environment $env) {
    if ($node instanceof ModuleNode) {
      array_pop($this->_moduleStack);
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
    foreach ($node->getInlineSchemaCandidates() as $candidate) {
      $callback = $this->tryInline($candidate, $env);
      if (!is_null($callback)) {
        $node->setInlinedSchema($candidate->qualifier, $callback);
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
        throw new SyntaxError(sprintf('An exception has been thrown during the compilation of a template ("%s").', $error->getMessage()), -1, $source, $error);
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
    /** @var ModuleNode $module */
    $module   = end($this->_moduleStack);
    $classEnd = $module->getNode('class_end');
    $macros   = $module->getNode('macros');

    if (!$classEnd->hasNode($schema->qualifier)) {
      try {
        $subModule = $this->compile($schema, $env);

        foreach ($subModule->getNode('class_end') as $name => $classEndNode) {
          $classEnd->setNode($name, $classEndNode);
        }

        foreach ($subModule->getNode('macros') as $name => $macroNode) {
          $macros->setNode($name, $macroNode);
        }

        $node = new InlineTemplateNode($schema, $subModule);
        $classEnd->setNode($schema->qualifier, $node);
      } catch (Throwable $error) {
        throw $error;
      }
    }

    return $classEnd->hasNode($schema->qualifier)
      ? $classEnd->getNode($schema->qualifier)->getAttribute('name')
      : null;
  }
}
