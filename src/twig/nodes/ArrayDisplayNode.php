<?php

namespace lenz\contentfield\twig\nodes;

use lenz\contentfield\Config;
use lenz\contentfield\models\fields\ArrayField;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\schemas\TemplateSchema;
use Throwable;
use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;

/**
 * Class ArrayDisplayNode
 *
 * @property ArrayField $_field
 * @method ArrayField getField()
 */
class ArrayDisplayNode extends DisplayNode
{
  /**
   * ArrayDisplayNode constructor.
   *
   * @param AbstractExpression $value
   * @param ArrayField $field
   * @param AbstractExpression|null $variables
   * @param bool $forceInline
   * @param int $line
   * @param string|null $tag
   */
  public function __construct(
    AbstractExpression $value,
    ArrayField $field,
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
    $member = $this->_field->member;
    if (
      !Config::getInstance()->useTemplateInlining() ||
      !($member instanceof InstanceField)
    ) {
      return [];
    }

    return array_filter(
      $member->getResolvedSchemas(),
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
   * @param Compiler $compiler
   */
  protected function addDisplay(Compiler $compiler): void {
    if ($this->usesIndexDisplay()) {
      parent::addDisplay($compiler);
      return;
    }

    $compiler
      ->write("if (\$displayContent instanceof \\lenz\\contentfield\\models\\values\\ArrayValue) {\n")
        ->indent()
        ->write("\$displayIterator = \$displayContent->getIterator();\n")
        ->write("\$displayVariables['loop'] = \$displayIterator;\n")
        ->write("foreach (\$displayIterator as \$displayContentItem) {\n")
          ->indent()
          ->write("if (\$displayContentItem->hasCachedOutput()) {\n")
            ->indent()
            ->write("yield \$displayContentItem->getCachedOutput();\n")
            ->write("continue;\n")
            ->outdent()
          ->write("}\n\n");
          $this->addInstanceDisplay($compiler, '$displayContentItem')
          ->write("\n")
          ->outdent()
        ->write("}\n")
        ->outdent()
      ->write("}\n");
  }
}
