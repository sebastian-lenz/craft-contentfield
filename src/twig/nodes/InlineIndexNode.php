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
      'name' => 'contentfieldDisplay',
      'templates' => [],
    ]);
  }

  /**
   * @param string $qualifier
   * @return string|null
   */
  public function getInlinedSchema(string $qualifier): ?string {
    $templates = $this->getAttribute('templates');

    return array_key_exists($qualifier, $templates)
      ? $templates[$qualifier]
      : null;
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
   * @param Compiler $compiler
   */
  public function compile(Compiler $compiler) {
    $templates = $this->getAttribute('templates');

    $compiler
      ->addDebugInfo($this)
      ->write(sprintf("public function %s(mixed \$instance, array \$variables = []) {\n", $this->getAttribute('name')))
      ->indent()
        ->write("if (is_callable(\$instance)) {\n")
          ->indent()
          ->write("\$instance = \$instance(\$variables);\n")
          ->outdent()
        ->write("}\n\n")
        ->write("if (\$instance instanceof \\lenz\\contentfield\\models\\values\\InstanceValue) {\n")
          ->indent()
          ->write("if (!\$instance->isVisible()) {\n")
            ->indent()
            ->write("return;\n")
            ->outdent()
          ->write("} elseif (\$instance->hasCachedOutput()) {\n")
            ->indent()
            ->write("yield \$instance->getCachedOutput();\n")
            ->outdent()
          ->write("} else switch (\$instance->getSchema()->qualifier) {\n")
            ->indent();

    foreach ($templates as $qualifier => $callback) {
      $compiler->write(sprintf("case \"%s\": yield from \$this->%s(\$instance, \$variables); break;\n", $qualifier, $callback));
    }

    $compiler
            ->write("default: yield from \$instance->display(\$variables);\n")
            ->outdent()
          ->write("}\n")
          ->outdent()
        ->write("} elseif (\$instance instanceof \\lenz\\contentfield\\twig\\DisplayInterface) {\n")
          ->indent()
          ->write("yield from \$instance->display(\$variables);\n")
          ->outdent()
        ->write("} elseif (\$instance instanceof \\lenz\\contentfield\\models\\values\\ValueInterface) {\n")
          ->indent()
          ->write("yield \$instance->getHtml();\n")
          ->outdent()
        ->write("} elseif (\$instance instanceof \Generator) {\n")
          ->indent()
          ->write("yield from \$instance;\n")
          ->outdent()
        ->write("} else {\n")
          ->indent()
          ->write("yield (string)\$instance;\n")
          ->outdent()
        ->write("}\n")
        ->outdent()
      ->write("}\n\n");
  }
}
