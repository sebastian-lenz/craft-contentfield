<?php

namespace lenz\contentfield\twig\tokenParsers;

use lenz\contentfield\twig\nodes\SiblingsNode;
use Twig\Node\Expression\ConstantExpression;
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
    'addBack',
    'limit',
    'only',
    'until',
    'with',
  ];

  const ALLOW_FUNCTION = ['only'];


  /**
   * @inheritdoc
   */
  public function parse(Token $token) {
    $parser     = $this->parser;
    $expression = $parser->getExpressionParser();
    $stream     = $parser->getStream();
    $nodes      = [];

    while ($next = $stream->nextIf(Token::NAME_TYPE, self::ATTRIBUTES)) {
      $name = $next->getValue();
      if ($name == 'addBack') {
        $nodes['addBack'] = new ConstantExpression(true, $next->getLine());
      } else {
        $nodes[$name] = $expression->parseExpression(0, in_array($name, self::ALLOW_FUNCTION));
      }
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
