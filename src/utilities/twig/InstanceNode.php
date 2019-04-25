<?php

namespace lenz\contentfield\utilities\twig;

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;

/**
 * Class InstanceNode
 */
class InstanceNode extends Node
{
  /**
   * InstanceNode constructor.
   *
   * @param AbstractExpression $value
   * @param $line
   * @param null $tag
   */
  public function __construct(AbstractExpression $value, $line, $tag = null) {
    parent::__construct(['value' => $value], [], $line, $tag);
  }

  /**
   * @inheritDoc
   */
  public function compile(Compiler $compiler) {
    $compiler
      ->addDebugInfo($this)
      ->subcompile($this->getNode('value'))
      ->raw("->display();\n");
  }
}
