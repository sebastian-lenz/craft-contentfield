<?php

namespace lenz\contentfield\twig\tokenParsers;

use lenz\contentfield\twig\nodes\SiblingsNode;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * Class SiblingsTokenParser
 */
class SiblingsTokenParser extends AbstractTokenParser
{
  /**
   * List all supported attributes.
   */
  const ATTRIBUTES = [
    'limit',
    'only',
    'until',
    'with',
  ];

  /**
   * @inheritdoc
   */
  public function parse(Token $token) {
    $parser = $this->parser;
    $stream = $parser->getStream();
    $nodes  = [];

    while ($next = $stream->nextIf(Token::NAME_TYPE, self::ATTRIBUTES)) {
      $nodes[$next->getValue()] = $this->parser->getExpressionParser()->parseExpression();
    }

    $stream->expect(Token::BLOCK_END_TYPE);

    return new SiblingsNode($nodes, $token->getLine(), $this->getTag());
  }

  /**
   * @inheritdoc
   */
  public function getTag() {
    return 'siblings';
  }
}
