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
    bool $forceInline = false,
    int $line = 0,
    string $tag = null
  ) {
    parent::__construct($value, $field, $variables, $forceInline, $line, $tag);
  }

  /**
   * @inheritDoc
   * @throws Throwable
   */
  public function getInlineSchemaCandidates(): array {
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
  public function usesIndexDisplay(): bool {
    return count($this->_inlinedSchemas) == 0;
  }


  // Protected methods
  // -----------------

  /**
   * @inerhitDoc
   */
  protected function addDisplay(Compiler $compiler): void {
    if ($this->usesIndexDisplay()) {
      parent::addDisplay($compiler);
      return;
    }

    $compiler
      ->write("if (\$displayContent instanceof \\lenz\\contentfield\\models\\values\\InstanceValue && \$displayContent->isVisible()) {\n")
        ->indent()
        ->write("if (\$displayContent->hasCachedOutput()) {\n")
          ->indent()
          ->write("yield \$displayContent->getCachedOutput();\n")
          ->outdent()
        ->write("} else {\n")
          ->indent();

    $this->addInstanceDisplay($compiler);

    $compiler
          ->outdent()
        ->write("}\n")
        ->outdent()
      ->write("}\n");
  }
}
