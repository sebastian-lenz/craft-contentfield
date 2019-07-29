<?php

namespace lenz\contentfield\twig\nodes;

use lenz\contentfield\Config;
use lenz\contentfield\models\fields\ArrayField;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\schemas\TemplateSchema;
use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;

/**
 * Class ArrayDisplayNode
 * @property ArrayField $_field
 * @method ArrayField getField()
 */
class ArrayDisplayNode extends DisplayNode
{
  /**
   * ArrayDisplayNode constructor.
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
    $forceInline = false,
    $line = 0,
    $tag = null
  ) {
    parent::__construct($value, $field, $variables, $forceInline, $line, $tag);
  }

  /**
   * @inheritDoc
   */
  public function getInlineSchemaCandidates() {
    $member = $this->_field->member;
    if (
      !Config::getInstance()->useTemplateInlining() ||
      !($member instanceof InstanceField)
    ) {
      return [];
    }

    return array_filter(
      $member->getDependedSchemas(),
      function($schema) {
        return (
          $schema instanceof TemplateSchema &&
          ($this->_forceInline || $schema->inline)
        );
      }
    );
  }


  // Protected methods
  // -----------------

  /**
   * @param Compiler $compiler
   */
  protected function addDisplay(Compiler $compiler) {
    if (count($this->_inlinedSchemas) == 0) {
      return parent::addDisplay($compiler);
    }

    $compiler
      ->write("if (\$displayContent instanceof \\lenz\\contentfield\\models\\values\\ArrayValue) {\n")
        ->indent()
        ->write("\$displayLoopIndex = 0;\n")
        ->write("\$displayLoopCount = \$displayContent->count();\n")
        ->write("foreach (\$displayContent->toArray() as \$displayContentItem) {\n")
          ->indent()
          ->write("if (\$displayContentItem->hasCachedOutput()) {\n")
            ->indent()
            ->write("echo \$displayContentItem->getCachedOutput();\n")
            ->write("continue;\n")
            ->outdent()
          ->write("}\n\n")
          ->write("\$displayVariables['loop'] = \\lenz\\contentfield\\models\\values\\ArrayValue::createLoopVariable(\$displayLoopIndex, \$displayLoopCount);\n");

    $this->addInstanceDisplay($compiler, '$displayContentItem', '$displayVariables');

    $compiler
          ->write("\n")
          ->write("\$displayLoopIndex += 1;\n")
          ->outdent()
        ->write("}\n")
        ->outdent()
      ->write("}\n");
  }
}
