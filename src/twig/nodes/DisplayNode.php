<?php

namespace lenz\contentfield\twig\nodes;

use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\schemas\TemplateSchema;
use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;

/**
 * Class DisplayNode
 */
class DisplayNode extends Node
{
  /**
   * @var AbstractField|null
   */
  protected $_field;

  /**
   * @var bool
   */
  protected $_forceInline;

  /**
   * @var array
   */
  protected $_inlinedSchemas = [];


  /**
   * InstanceNode constructor.
   *
   * @param AbstractExpression $value
   * @param AbstractField|null $field
   * @param AbstractExpression|null $variables
   * @param bool $forceInline
   * @param int $line
   * @param string|null $tag
   */
  public function __construct(
    AbstractExpression $value,
    AbstractField $field = null,
    AbstractExpression $variables = null,
    $forceInline = false,
    $line = 0,
    $tag = null
  ) {
    $nodes = ['value' => $value];
    if (null !== $variables) {
      $nodes['variables'] = $variables;
    }

    $this->_field = $field;
    $this->_forceInline = $forceInline;
    
    parent::__construct($nodes, [], $line, $tag);
  }

  /**
   * @inheritDoc
   */
  public function compile(Compiler $compiler) {
    // Set `$displayContent` to the passed variable
    $compiler
      ->addDebugInfo($this)
      ->write("\$displayContent = ")
      ->subcompile($this->getNode('value'))
      ->write(";\n");

    // Set `$displayVariables` to the `with` node part
    $compiler->write("\$displayVariables = ");
    $this->addTemplateArguments($compiler);
    $compiler->write(";\n");

    // Let the current class handle the display code
    $this->addDisplay($compiler);
  }

  /**
   * @return AbstractField|null
   */
  public function getField() {
    return $this->_field;
  }

  /**
   * @return TemplateSchema[]
   */
  public function getInlineSchemaCandidates() {
    return [];
  }

  /**
   * @param string $qualifier
   * @param string $callback
   */
  public function setInlinedSchema(string $qualifier, string $callback) {
    $this->_inlinedSchemas[$qualifier] = $callback;
  }


  // Protected methods
  // -----------------

  /**
   * @param Compiler $compiler
   */
  protected function addTemplateArguments(Compiler $compiler) {
    if ($this->hasNode('variables')) {
      $compiler->raw('twig_to_array(');
      $compiler->subcompile($this->getNode('variables'));
      $compiler->raw(')');
    } else {
      $compiler->raw('[]');
    }
  }

  /**
   * @param Compiler $compiler
   */
  protected function addDisplay(Compiler $compiler) {
    $compiler
      ->write("if (\$displayContent instanceof \\lenz\\contentfield\\twig\\DisplayInterface) {\n")
        ->indent()
        ->write("\$displayContent->display(\$displayVariables);\n")
        ->outdent()
      ->write("} elseif (\$displayContent instanceof \\lenz\\contentfield\\models\\values\\ValueInterface) {\n")
        ->indent()
        ->write("echo \$displayContent->getHtml();\n")
        ->outdent()
      ->write("} else {\n")
        ->indent()
        ->write("echo (string)\$displayContent;\n")
        ->outdent()
      ->write("}\n");
  }

  /**
   * @param Compiler $compiler
   * @param string $instanceVar
   * @param string $variablesVar
   */
  protected function addInstanceDisplay(
    Compiler $compiler,
    string $instanceVar = '$displayContent',
    string $variablesVar = '$displayVariables'
  ) {
    $compiler
      ->write("switch ({$instanceVar}->getType()) {\n")
      ->indent();

    foreach ($this->_inlinedSchemas as $qualifier => $callback) {
      $compiler->write(sprintf("case '%s': \$this->%s({$instanceVar}, {$variablesVar}); break;\n", $qualifier, $callback));
    }

    $compiler
      ->write("default: {$instanceVar}->display({$variablesVar});\n")
      ->outdent()
      ->write("}\n");
  }
}
