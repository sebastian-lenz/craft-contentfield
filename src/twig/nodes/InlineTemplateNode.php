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
  private $_schema;


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
      ->write(sprintf("public function %s(\$instance, \$variables = []) {\n", $this->getAttribute('name')))
        ->indent()
        ->write("\$context = \$this->env->mergeGlobals(\\lenz\\contentfield\\models\\schemas\\TemplateSchema::normalizedVariables(\$instance, \$variables));\n")
        ->subcompile($body->getNode('body'))
        ->outdent()
      ->write("}\n\n");
  }
}
