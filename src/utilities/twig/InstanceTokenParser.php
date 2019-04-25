<?php

namespace lenz\contentfield\utilities\twig;

use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * Class InstanceTokenParser
 */
class InstanceTokenParser extends AbstractTokenParser
{
  /**
   * @inheritdoc
   */
  public function parse(Token $token) {
    $parser = $this->parser;
    $stream = $parser->getStream();

    $value = $parser->getExpressionParser()->parseExpression();
    $stream->expect(Token::BLOCK_END_TYPE);

    return new InstanceNode($value, $token->getLine(), $this->getTag());
  }

  /**
   * @inheritdoc
   */
  public function getTag() {
    return 'instance';
  }
}
