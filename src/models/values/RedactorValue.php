<?php

namespace lenz\contentfield\models\values;

use Craft;
use craft\base\ElementInterface;
use craft\helpers\StringHelper;
use Exception;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\models\fields\RedactorField;
use lenz\contentfield\twig\DisplayInterface;
use Throwable;
use Twig\Markup;

/**
 * Class RedactorValue
 *
 * @property RedactorField $_field
 */
class RedactorValue extends Value implements DisplayInterface, ReferenceMapValueInterface
{
  /**
   * @var string|null
   */
  private $_compiledContent = null;

  /**
   * @var Markup[]|null
   */
  private $_pages = null;

  /**
   * @var string
   */
  private $_parsedContent;

  /**
   * @var array|null
   */
  private $_parsedTokens;

  /**
   * @var string
   */
  private $_rawContent;

  /**
   * @var bool
   */
  static $forceNativeRefParse = false;


  /**
   * RedactorValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface $parent
   * @param RedactorField $field
   */
  public function __construct($data, ValueInterface $parent, RedactorField $field) {
    parent::__construct($parent, $field);

    $this->setRawContent(is_string($data) ? $data : '');
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
    return $this->getCompiledContent();
  }

  /**
   * @inheritDoc
   */
  public function display(array $variables = []) {
    echo $this->getCompiledContent();
  }

  /**
   * @inheritdoc
   */
  public function getHtml() {
    return new Markup($this->getCompiledContent(), Craft::$app->charset);
  }

  /**
   * @return Markup[]
   */
  public function getPages(): array {
    if ($this->_pages !== null) {
      return $this->_pages;
    }

    $this->_pages = [];
    $pages = explode('<!--pagebreak-->', $this->getCompiledContent());

    foreach ($pages as $page) {
      $this->_pages[] = new Markup($page, Craft::$app->charset);
    }

    return $this->_pages;
  }

  /**
   * @param int $pageNumber
   * @return Markup|null
   */
  public function getPage(int $pageNumber) {
    $pages = $this->getPages();

    if (isset($pages[$pageNumber - 1])) {
      return $pages[$pageNumber - 1];
    }

    return null;
  }

  /**
   * Required for compatibility with craft\redactor\Field::serializeValue
   * @return string
   */
  public function getRawContent() {
    return $this->_rawContent;
  }

  /**
   * @inheritDoc
   */
  public function getReferenceMap(ReferenceMap $map = null) {
    if (is_null($map)) {
      $map = new ReferenceMap();
    }

    if (is_null($this->_parsedTokens)) {
      return $map;
    }

    foreach ($this->_parsedTokens as $elementType => $tokens) {
      foreach (array_keys($tokens) as $id) {
        $map->push($elementType, $id);
      }
    }

    return $map;
  }

  /**
   * @return int
   */
  public function getTotalPages(): int {
    return count($this->getPages());
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return empty($this->_rawContent);
  }

  /**
   * @param string $str
   */
  public function setRawContent(string $str) {
    $this->_compiledContent = null;
    $this->_pages = null;
    $this->_rawContent = $str;

    $elements = Craft::$app->getElements();
    if (self::$forceNativeRefParse) {
      $this->_parsedContent = $elements->parseRefs($str);
      $this->_parsedTokens = null;
      return;
    }

    if (!StringHelper::contains($str, '{')) {
      $this->_parsedContent = $str;
      $this->_parsedTokens = null;
      return;
    }

    try {
      $allRefTagTokens = [];
      $count = 0;
      $str = preg_replace_callback(
        '/\{([\w\\\\]+)\:([^\:\}]+)(?:\:([^\}]+))?\}/',
        function($matches) use (&$allRefTagTokens, $elements) {
          // Does it already have a full element type class name?
          if (is_subclass_of($matches[1], ElementInterface::class)) {
            $elementType = $matches[1];
          } else if (($elementType = $elements->getElementTypeByRefHandle($matches[1])) === null) {
            // Leave the tag alone
            return $matches[0];
          }

          if (!is_numeric($matches[2])) {
            throw new Exception('Unsupported reference type');
          }

          $token = '{' . StringHelper::randomString(9) . '}';
          $allRefTagTokens[$elementType][intval($matches[2])][] = [$token, $matches];
          return $token;
        },
        $str, -1, $count
      );

      $this->_parsedContent = $str;
      $this->_parsedTokens = $count == 0 ? null : $allRefTagTokens;
    } catch (Throwable $error) {
      $this->_parsedContent = $elements->parseRefs($str);
      $this->_parsedTokens = null;
    }
  }


  // Private methods
  // ---------------

  /**
   * @return string
   */
  private function compile() {
    if (is_null($this->_parsedTokens) || count($this->_parsedTokens) == 0) {
      return $this->_parsedContent;
    }

    try {
      $loader = $this->getContent()->getReferenceLoader();
    } catch (Throwable $error) {
      $loader = null;
    }

    if (is_null($loader)) {
      return Craft::$app->getElements()->parseRefs($this->_rawContent);
    }

    $replace = [];
    $search  = [];
    $str     = $this->_parsedContent;

    foreach ($this->_parsedTokens as $elementType => $tokensByName) {
      $elements = $loader->getElements($elementType);

      foreach ($tokensByName as $refName => $tokens) {
        $element = $elements[$refName] ?? null;

        foreach ($tokens as list($token, $matches)) {
          $search[] = $token;
          $replace[] = $this->getTokenReplacement($matches, $element);
        }
      }
    }

    // Swap the tokens with the references
    return str_replace($search, $replace, $str);
  }

  /**
   * @return string
   */
  private function getCompiledContent() {
    if (is_null($this->_compiledContent)) {
      $this->_compiledContent = $this->compile();
    }

    return $this->_compiledContent;
  }

  /**
   * Returns the replacement for a given reference tag.
   *
   * @param ElementInterface|null $element
   * @param array $matches
   * @return string
   * @see parseRefs()
   */
  private function getTokenReplacement(array $matches, ElementInterface $element = null): string {
    if ($element === null) {
      // Put the ref tag back
      return $matches[0];
    }

    if (empty($matches[3]) || !isset($element->{$matches[3]})) {
      // Default to the URL
      return (string)$element->getUrl();
    }

    try {
      $value = $element->{$matches[3]};

      if (is_object($value) && !method_exists($value, '__toString')) {
        throw new Exception('Object of class ' . get_class($value) . ' could not be converted to string');
      }

      return Craft::$app->getElements()->parseRefs((string)$value);
    } catch (Throwable $e) {
      // Log it
      Craft::error('An exception was thrown when parsing the ref tag "' . $matches[0] . "\":\n" . $e->getMessage(), __METHOD__);

      // Replace the token with the original ref tag
      return $matches[0];
    }
  }
}
