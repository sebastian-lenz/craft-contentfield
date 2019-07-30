<?php

namespace lenz\contentfield\twig\nodes;

use lenz\contentfield\Config;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\schemas\TemplateSchema;
use Throwable;
use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;

/**
 * Class InstanceDisplayNode
 *
 * @property InstanceField $_field
 * @method InstanceField getField()
 */
class InstanceDisplayNode extends DisplayNode
{
  /**
   * InstanceDisplayNode constructor.
   *
   * @param AbstractExpression $value
   * @param InstanceField $field
   * @param AbstractExpression|null $variables
   * @param bool $forceInline
   * @param int $line
   * @param string|null $tag
   */
  public function __construct(
    AbstractExpression $value,
    InstanceField $field,
    AbstractExpression $variables = null,
    $forceInline = false,
    $line = 0,
    $tag = null
  ) {
    parent::__construct($value, $field, $variables, $forceInline, $line, $tag);
  }

  /**
   * @inheritDoc
   * @throws Throwable
   */
  public function getInlineSchemaCandidates() {
    if (!Config::getInstance()->useTemplateInlining()) {
      return [];
    }

    return array_filter(
      $this->_field->getDependedSchemas(),
      function($schema) {
        return (
          $schema instanceof TemplateSchema &&
          ($this->_forceInline || $schema->inline)
        );
      }
    );
  }

  /**
   * @inheritDoc
   */
  public function usesIndexDisplay() {
    return count($this->_inlinedSchemas) == 0;
  }


  // Protected methods
  // -----------------

  /**
   * @param Compiler $compiler
   */
  protected function addDisplay(Compiler $compiler) {
    if ($this->usesIndexDisplay()) {
      parent::addDisplay($compiler);
      return;
    }

    $compiler
      ->write("if (\$displayContent instanceof \\lenz\\contentfield\\models\\values\\InstanceValue) {\n")
        ->indent()
        ->write("if (\$displayContent->hasCachedOutput()) {\n")
          ->indent()
          ->write("echo \$displayContent->getCachedOutput();\n")
          ->outdent()
        ->write("} else {\n")
          ->indent();

    $this->addInstanceDisplay($compiler, '$displayContent', '$displayVariables');

    $compiler
          ->outdent()
        ->write("}\n")
        ->outdent()
      ->write("}\n");
  }
}
