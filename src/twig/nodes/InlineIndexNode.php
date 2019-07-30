<?php

namespace lenz\contentfield\twig\nodes;

use Twig\Compiler;
use Twig\Node\Node;

/**
 * Class InlineIndexNode
 */
class InlineIndexNode extends Node
{
  /**
   * InlineNode constructor.
   */
  public function __construct() {
    parent::__construct([], [
      'name'      => 'contentfieldDisplay',
      'templates' => [],
    ]);
  }

  /**
   * @param string $qualifier
   * @param string $callbackName
   */
  public function setInlinedSchema(string $qualifier, string $callbackName) {
    $templates = $this->getAttribute('templates');
    $templates[$qualifier] = $callbackName;

    $this->setAttribute('templates', $templates);
  }

  /**
   * @inheritDoc
   */
  public function compile(Compiler $compiler) {
    $templates = $this->getAttribute('templates');

    $compiler
      ->addDebugInfo($this)
      ->write(sprintf("public function %s(\$instance, \$variables = []) {\n", $this->getAttribute('name')))
      ->indent()
        ->write("if (\$instance instanceof \\lenz\\contentfield\\models\\values\\InstanceValue) {\n")
          ->indent()
          ->write("if (\$instance->hasCachedOutput()) {\n")
            ->indent()
            ->write("echo \$instance->getCachedOutput();\n")
            ->outdent()
          ->write("} else switch (\$instance->getType()) {\n")
            ->indent();

    foreach ($templates as $qualifier => $callback) {
      $compiler->write(sprintf("case \"%s\": return \$this->%s(\$instance, \$variables);\n", $qualifier, $callback));
    }

    $compiler
            ->write("default: return \$instance->display(\$variables);\n")
            ->outdent()
          ->write("}\n")
          ->outdent()
        ->write("} elseif (\$instance instanceof \\lenz\\contentfield\\twig\\DisplayInterface) {\n")
          ->indent()
          ->write("\$instance->display(\$variables);\n")
          ->outdent()
        ->write("} elseif (\$instance instanceof \\lenz\\contentfield\\models\\values\\ValueInterface) {\n")
          ->indent()
          ->write("echo \$instance->getHtml();\n")
          ->outdent()
        ->write("} else {\n")
          ->indent()
          ->write("echo (string)\$instance;\n")
          ->outdent()
        ->write("}\n")
        ->outdent()
      ->write("}\n\n");
  }
}
