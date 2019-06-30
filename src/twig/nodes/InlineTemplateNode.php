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
      'name' => 'inlined_' . md5($schema->template),
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
      ->write(sprintf("public function %s(\$instance, \$variables = [], \$loopParent = [], \$loopIndex = 0, \$loopCount = 1) {\n", $this->getAttribute('name')))
        ->indent()
        ->write("\$context = array_merge(\n")
          ->indent()
          ->write("[\n")
            ->indent()
            ->write("'entry'          => \$instance->getContent()->getOwner(),\n")
            ->write("'instance'       => \$instance,\n")
            ->write("'isChunkRequest' => false,\n")
            ->write("'model'          => \$instance->getModel(),\n")
            ->write("'editAttributes' => \\lenz\\contentfield\\Plugin::\$IS_ELEMENT_PREVIEW ? \$instance->getEditAttributes() : '',\n")
            ->write("'loop'           => [\n")
              ->indent()
              ->write("'index'     => \$loopIndex + 1,\n")
              ->write("'index0'    => \$loopIndex,\n")
              ->write("'revindex'  => \$loopCount - \$loopIndex,\n")
              ->write("'revindex0' => \$loopCount - \$loopIndex - 1,\n")
              ->write("'first'     => \$loopIndex == 0,\n")
              ->write("'last'      => \$loopIndex == \$loopCount - 1,\n")
              ->write("'length'    => \$loopCount,\n")
              ->write("'parent'    => \$loopParent,\n")
              ->outdent()
            ->write("]\n")
            ->outdent()
          ->write("],\n")
          ->write("\$instance->getValues(),\n")
          ->write("\$variables\n")
          ->outdent()
        ->write(");\n\n")
        ->subcompile($body->getNode('body'))
        ->outdent()
      ->write("}\n\n");
  }
}
