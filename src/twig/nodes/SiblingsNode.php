<?php

namespace lenz\contentfield\twig\nodes;

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;

/**
 * Class SiblingsNode
 */
class SiblingsNode extends Node
{
  /**
   * SiblingsNode constructor.
   *
   * @param AbstractExpression[] $nodes
   * @param int $line
   * @param string|null $tag
   */
  public function __construct(array $nodes, int $line = 0, string $tag = null) {
    parent::__construct($nodes, [], $line, $tag);
  }

  /**
   * @param Compiler $compiler
   */
  public function compile(Compiler $compiler) {
    $compiler
      ->write("if (array_key_exists('loop', \$context) && (\$context['loop'] instanceof \\lenz\\contentfield\\helpers\\loops\\IteratorLoop)) {\n")
        ->indent()
        ->write("\$displayIterator = \$context['loop']->getSiblings(");
    $this->addArguments($compiler, ['limit', 'only', 'until', 'addBack']);
    $compiler
        ->raw(");\n")
        ->write("\$displayVariables = ");
    $this->addWith($compiler);
    $compiler
        ->raw(";\n")
        ->write("\$displayVariables['loop'] = \$displayIterator;\n")
        ->write("\n")
        ->write("foreach (\$displayIterator as \$displayContentItem) {\n")
          ->indent()
          ->write("\$this->contentfieldDisplay(\$displayContentItem, \$displayVariables);\n")
          ->outdent()
        ->write("}\n")
        ->outdent()
      ->write('}');
  }


  // Protected methods
  // -----------------

  /**
   * @param Compiler $compiler
   * @param string $name
   */
  protected function addArgument(Compiler $compiler, string $name) {
    if ($this->hasNode($name)) {
      $compiler->subcompile($this->getNode($name));
    } else {
      $compiler->raw('null');
    }
  }

  /**
   * @param Compiler $compiler
   * @param array $names
   */
  protected function addArguments(Compiler $compiler, array $names) {
    $isFirst = true;
    foreach ($names as $name) {
      if (!$isFirst) {
        $compiler->raw(', ');
      }

      $isFirst = false;
      $this->addArgument($compiler, $name);
    }
  }

  /**
   * @param Compiler $compiler
   */
  protected function addWith(Compiler $compiler) {
    if ($this->hasNode('with')) {
      $compiler->raw('twig_to_array(');
      $compiler->subcompile($this->getNode('with'));
      $compiler->raw(')');
    } else {
      $compiler->raw('[]');
    }
  }
}
