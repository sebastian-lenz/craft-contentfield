<?php

namespace lenz\contentfield\helpers\redactor;

use Craft;
use Exception;
use lenz\contentfield\helpers\ReferenceLoader;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\models\values\RedactorValue;
use Throwable;

/**
 * Class CustomTokenizer
 */
class CustomTokenizer extends AbstractTokenizer
{
  /**
   * @var string
   */
  private string $_parsedContent;

  /**
   * @var Token[]
   */
  private array $_tokens = [];

  /**
   * @var RedactorValue
   */
  private RedactorValue $_value;


  /**
   * @param RedactorValue $value
   * @param string $content
   * @throws Exception
   */
  public function __construct(RedactorValue $value, string $content) {
    parent::__construct($content);

    $this->_value = $value;
    $this->_parsedContent = $this->parse();
  }

  /**
   * @inheritDoc
   */
  public function hasRefs(): bool {
    return count($this->_tokens) > 0;
  }

  /**
   * @inheritDoc
   */
  public function registerReferences(ReferenceMap $map): ReferenceMap {
    foreach ($this->_tokens as $token) {
      $map->push($token->elementType, $token->ref, $token->siteId);
    }

    return $map;
  }


  // Protected methods
  // -----------------

  /**
   * @return string
   * @throws Exception
   */
  protected function compile(): string {
    try {
      $loader = $this->_value->getContent()->getReferenceLoader();
    } catch (Throwable) {
      $loader = null;
    }

    return is_null($loader)
      ? Craft::$app->getElements()->parseRefs($this->_rawContent)
      : $this->compileWithLoader($loader);
  }

  /**
   * @param ReferenceLoader $loader
   * @return string
   * @throws Exception
   */
  protected function compileWithLoader(ReferenceLoader $loader): string {
    $replace = [];
    $search = [];
    $str = $this->_parsedContent;

    foreach ($this->_tokens as $token) {
      $search[] = $token->placeholder;
      $replace[] = $token->getReplacement(
        $loader->getElement($token->elementType, $token->ref, $token->siteId)
      );
    }

    // Swap the tokens with the references
    return str_replace($search, $replace, $str);
  }

  /**
   * @return string
   * @throws Exception
   */
  protected function parse(): string {
    return preg_replace_callback(
      '/{([\w\\\\]+):([^@:}]+)(?:@([^:}]+))?(?::([^}| ]+))?(?: *\|\| *([^}]+))?}/',
      fn(array $matches) => $this->parseToken($matches),
      $this->_rawContent
    );
  }

  /**
   * Extracted ref parser from `craft\services\Elements::parseRefs`
   *
   * @param array $match
   * @return string
   * @throws Exception
   */
  protected function parseToken(array $match): string {
    try {
      $token = new Token($match);
    } catch (Throwable) {
      return Token::getFallback($match);
    }

    $this->_tokens[] = $token;
    return $token->placeholder;
  }
}
