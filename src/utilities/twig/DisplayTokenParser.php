<?php

namespace lenz\contentfield\utilities\twig;

use Twig\TokenParser\AbstractTokenParser;
use Twig_Token;

/**
 * Class DisplayTokenParser
 */
class DisplayTokenParser extends AbstractTokenParser
{
  /**
   * @inheritdoc
   */
  public function parse(Twig_Token $token) {
    $parser = $this->parser;
    $stream = $parser->getStream();
    $variables = null;

    $value = $parser->getExpressionParser()->parseExpression();

    if ($stream->nextIf(Twig_Token::NAME_TYPE, 'with')) {
      $variables = $this->parser->getExpressionParser()->parseExpression();
    }

    $stream->expect(Twig_Token::BLOCK_END_TYPE);

    return new DisplayNode($value, $variables, $token->getLine(), $this->getTag());
  }

  /**
   * @inheritdoc
   */
  public function getTag() {
    return 'display';
  }
}
