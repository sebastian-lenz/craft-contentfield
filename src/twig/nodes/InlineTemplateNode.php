<?php

namespace lenz\contentfield\twig\nodes;

use lenz\contentfield\models\schemas\TemplateSchema;
use Twig\Compiler;
use Twig\Node\ModuleNode;
use Twig\Node\Node;

/**
 * Class InlineTemplateNode
 */
class InlineTemplateNode extends Node
{
  /**
   * @var TemplateSchema
   */
  private TemplateSchema $_schema;


  /**
   * InlineTemplateNode constructor.
   */
  public function __construct(TemplateSchema $schema, ModuleNode $module) {
    parent::__construct([
      'body' => $module,
    ], [
      'name' => 'contentfieldDisplay_' . md5($schema->template),
    ]);

    $this->_schema = $schema;
  }

  public function compile(Compiler $compiler) {
    /** @var ModuleNode $body */
    $body = $this->getNode('body');

    $compiler
      ->addDebugInfo($this)
      ->write("/**\n")
      ->write(sprintf(" * %s\n", $this->_schema->template))
      ->write(" */\n")
      ->write(sprintf("public function %s(\$instance, array \$variables = []) {\n", $this->getAttribute('name')))
        ->indent()
        ->write("\$blocks = [];\n")
        ->write("\$macros = \$this->macros;\n")
        // Template variables must take precedence over globals, matching `Template::yield()`
        ->write("\$context = \\lenz\\contentfield\\models\\schemas\\TemplateSchema::normalizedVariables(\$instance, \$variables) + \$this->env->getGlobals();\n")
        // Extensions (e.g. Craft's profiler) hook into the module's display start / end
        ->subcompile($body->getNode('display_start'))
        ->subcompile($body->getNode('body'))
        ->subcompile($body->getNode('display_end'))
        // Ensure the method is always a generator, even if the template has no output
        ->write("return; yield;\n")
        ->outdent()
      ->write("}\n\n");
  }
}
