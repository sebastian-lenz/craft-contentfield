<?php

namespace lenz\contentfield\twig\tokenParsers;

use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\fields\ArrayField;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\Plugin;
use lenz\contentfield\twig\nodes\ArrayDisplayNode;
use lenz\contentfield\twig\nodes\DisplayNode;
use lenz\contentfield\twig\nodes\InstanceDisplayNode;
use Throwable;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Expression\NameExpression;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * Class DisplayTokenParser
 */
class DisplayTokenParser extends AbstractTokenParser
{
  /**
   * @inheritdoc
   */
  public function parse(Token $token) {
    $parser      = $this->parser;
    $stream      = $parser->getStream();
    $variables   = null;
    $forceInline = false;

    if ($stream->nextIf(Token::NAME_TYPE, 'inline')) {
      $forceInline = true;
    }

    $value = $parser->getExpressionParser()->parseExpression();

    if ($stream->nextIf(Token::NAME_TYPE, 'with')) {
      $variables = $this->parser->getExpressionParser()->parseExpression();
    }

    $stream->expect(Token::BLOCK_END_TYPE);

    $field = $this->resolveField($value);
    if ($field instanceof InstanceField) {
      return new InstanceDisplayNode($value, $field, $variables, $forceInline, $token->getLine(), $this->getTag());
    } elseif ($field instanceof ArrayField && $field->member instanceof InstanceField) {
      return new ArrayDisplayNode($value, $field, $variables, $forceInline, $token->getLine(), $this->getTag());
    }

    return new DisplayNode($value, $field, $variables, $forceInline, $token->getLine(), $this->getTag());
  }

  /**
   * @inheritdoc
   */
  public function getTag(): string {
    return 'display';
  }


  // Private methods
  // ---------------

  /**
   * Return the field with the given name on the the parsed template.
   *
   * @param string $name
   * @return AbstractField|null
   */
  private function getField(string $name): ?AbstractField {
    $schema = $this->getSchema();
    if (is_null($schema) || !is_string($name)) {
      return null;
    }

    return array_key_exists($name, $schema->fields)
      ? $schema->fields[$name]
      : null;
  }

  /**
   * Return the schema of the parsed template.
   *
   * @return AbstractSchema|null
   * @noinspection PhpInternalEntityUsedInspection
   */
  private function getSchema(): ?AbstractSchema {
    try {
      $source = $this->parser->getStream()->getSourceContext();
      $loader = Plugin::getInstance()->schemas->getTemplateLoader();
      return $loader->load($source->getName());
    } catch (Throwable $error) {
      return null;
    }
  }

  /**
   * Try to find the field displayed by the given name.
   *
   * @param AbstractExpression $name
   * @return AbstractField|null
   */
  private function resolveField(AbstractExpression $name): ?AbstractField {
    if ($name instanceof NameExpression) {
      return $this->getField($name->getAttribute('name'));
    }

    return null;
  }
}
