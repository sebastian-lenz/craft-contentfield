<?php

namespace lenz\contentfield\utilities\twig;

use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;
use Twig_Compiler;

/**
 * Class DisplayNode
 */
class DisplayNode extends Node
{
  /**
   * InstanceNode constructor.
   *
   * @param AbstractExpression $value
   * @param AbstractExpression|null $variables
   * @param int|null $line
   * @param string|null $tag
   */
  public function __construct(AbstractExpression $value, AbstractExpression $variables = null, $line = null, $tag = null) {
    $nodes = ['value' => $value];
    if (null !== $variables) {
      $nodes['variables'] = $variables;
    }
    
    parent::__construct($nodes, [], $line, $tag);
  }

  /**
   * @inheritDoc
   */
  public function compile(Twig_Compiler $compiler) {
    $compiler
      ->addDebugInfo($this)
      ->raw("\$displayContent = ")
      ->subcompile($this->getNode('value'))
      ->raw(";\n")
      ->raw("if (\$displayContent instanceof \\lenz\\contentfield\\utilities\\twig\\DisplayInterface) {")
        ->indent()
        ->raw("\$displayContent->display(");

    $this->addTemplateArguments($compiler);

    $compiler
        ->raw(");\n")
        ->outdent()
      ->raw("} elseif (\$displayContent instanceof \\lenz\\contentfield\\models\\values\\ValueInterface) {")
        ->indent()
        ->raw("echo \$displayContent->getHtml();")
        ->outdent()
      ->raw("} else {")
        ->indent()
        ->raw("echo (string)\$displayContent;")
        ->outdent()
      ->raw("}");
  }

  /**
   * @param Twig_Compiler $compiler
   */
  protected function addTemplateArguments(Twig_Compiler $compiler) {
    if ($this->hasNode('variables')) {
      $compiler->raw('twig_to_array(');
      $compiler->subcompile($this->getNode('variables'));
      $compiler->raw(')');
    }
  }
}
