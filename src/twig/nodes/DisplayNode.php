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
   * @phpstan-var AbstractField|null
   */
  protected ?AbstractField $_field;

  /**
   * @phpstan-var bool
   */
  protected bool $_forceInline;

  /**
   * @phpstan-var array
   */
  protected array $_inlinedSchemas = [];


  /**
   * DisplayNode constructor.
   *
   * @phpstan-param AbstractExpression $value
   * @phpstan-param AbstractField|null $field
   * @phpstan-param AbstractExpression|null $variables
   * @phpstan-param bool $forceInline
   * @phpstan-param int $line
   * @phpstan-param string|null $tag
   */
  public function __construct(
    AbstractExpression $value,
    AbstractField $field = null,
    AbstractExpression $variables = null,
    bool $forceInline = false,
    int $line = 0,
    string $tag = null
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
   * @phpstan-param Compiler $compiler
   */
  public function compile(Compiler $compiler): void {
    // Set `$displayContent` to the passed variable
    $compiler
      ->addDebugInfo($this)
      ->write("\$displayContent = ")
      ->subcompile($this->getNode('value'))
      ->raw(";\n");

    // Set `$displayVariables` to the `with` node part
    $compiler->write("\$displayVariables = ");
    $this->addTemplateArguments($compiler);
    $compiler->raw(";\n");

    // Let the current class handle the display code
    $this->addDisplay($compiler);
  }

  /**
   * @phpstan-return AbstractField|null
   */
  public function getField(): ?AbstractField {
    return $this->_field;
  }

  /**
   * @phpstan-return TemplateSchema[]
   */
  public function getInlineSchemaCandidates(): array {
    return [];
  }

  /**
   * @phpstan-param string $qualifier
   * @phpstan-param string $callback
   */
  public function setInlinedSchema(string $qualifier, string $callback): void {
    $this->_inlinedSchemas[$qualifier] = $callback;
  }

  /**
   * @phpstan-return bool
   */
  public function usesIndexDisplay(): bool {
    return true;
  }


  // Protected methods
  // -----------------

  /**
   * @phpstan-param Compiler $compiler
   */
  protected function addTemplateArguments(Compiler $compiler): void {
    if ($this->hasNode('variables')) {
      $compiler->raw('twig_to_array(');
      $compiler->subcompile($this->getNode('variables'));
      $compiler->raw(')');
    } else {
      $compiler->raw('[]');
    }
  }

  /**
   * @phpstan-param Compiler $compiler
   */
  protected function addDisplay(Compiler $compiler): void {
    $compiler
      ->write("if (is_array(\$displayContent) || \$displayContent instanceof \\lenz\\contentfield\\models\\values\\ArrayValue) {\n")
        ->indent()
        ->write("\$displayIterator = is_array(\$displayContent) ? new \lenz\contentfield\helpers\loops\IteratorLoop(\$displayContent) : \$displayContent->getIterator();\n")
        ->write("\$displayVariables['loop'] = \$displayIterator;\n")
        ->write("foreach (\$displayIterator as \$displayContentItem) {\n")
          ->indent()
          ->write("if (\$displayContentItem->hasCachedOutput()) {\n")
            ->indent()
            ->write("echo \$displayContentItem->getCachedOutput();\n")
            ->write("continue;\n")
            ->outdent()
          ->write("}\n\n");
          $this->addInstanceDisplay($compiler, '$displayContentItem')
          ->write("\n")
        ->outdent()
        ->write("}\n")
      ->outdent()
      ->write("} else {\n")
        ->indent()
        ->write("\$this->contentfieldDisplay(\$displayContent, \$displayVariables);\n")
      ->outdent()
      ->write("}\n");
  }

  /**
   * @phpstan-param Compiler $compiler
   * @phpstan-param string $instanceVar
   * @phpstan-param string $variablesVar
   * @phpstan-return Compiler
   * @noinspection PhpUnnecessaryCurlyVarSyntaxInspection (cause PhpStorm is stupid)
   */
  protected function addInstanceDisplay(
    Compiler $compiler,
    string $instanceVar = '$displayContent',
    string $variablesVar = '$displayVariables'
  ): Compiler {
    $compiler
      ->write("switch ({$instanceVar}->getSchema()->qualifier) {\n")
      ->indent();

    foreach ($this->_inlinedSchemas as $qualifier => $callback) {
      $compiler->write(sprintf("case '%s': \$this->%s({$instanceVar}, {$variablesVar}); break;\n", $qualifier, $callback));
    }

    return $compiler
      ->write("default: {$instanceVar}->display({$variablesVar});\n")
      ->outdent()
      ->write("}\n");
  }
}
