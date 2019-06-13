<?php

namespace lenz\contentfield\models\values;

use Craft;
use craft\base\ElementInterface;
use craft\helpers\StringHelper;
use lenz\contentfield\models\ReferenceMapValueInterface;
use lenz\contentfield\utilities\RedactorFieldData;
use lenz\contentfield\models\fields\RedactorField;
use lenz\contentfield\utilities\ReferenceMap;
use lenz\contentfield\utilities\twig\DisplayInterface;
use Throwable;
use yii\base\Exception;

/**
 * Class RedactorValue
 * @property RedactorField $_field
 */
class RedactorValue extends Value implements DisplayInterface, ReferenceMapValueInterface
{
  /**
   * @var string
   */
  private $_rawContent;

  /**
   * @var string
   */
  private $_parsedContent;

  /**
   * @var array|null
   */
  private $_parsedTokens;

  /**
   * @var RedactorFieldData
   */
  private $_value;

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
    return (string)$this->getRedactorFieldData();
  }

  /**
   * @inheritDoc
   */
  public function display(array $variables = []) {
    echo $this->getRedactorFieldData();
  }

  /**
   * @inheritdoc
   */
  public function getHtml() {
    return $this->getRedactorFieldData();
  }

  /**
   * Required for compatibility with craft\redactor\Field::serializeValue
   * @return string
   */
  public function getRawContent() {
    return $this->_rawContent;
  }

  /**
   * @return RedactorFieldData
   */
  public function getRedactorFieldData() {
    if (!isset($this->_value)) {
      $this->_value = new RedactorFieldData($this->getParsedContent());
    }

    return $this->_value;
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
   * @return bool
   */
  public function isEmpty() {
    return empty($this->_rawContent);
  }

  /**
   * @param string $str
   */
  public function setRawContent(string $str) {
    unset($this->_value);
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
            throw new \Exception('Unsupported reference type');
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
  private function getParsedContent() {
    if (is_null($this->_parsedTokens)) {
      return $this->_parsedContent;
    }

    $content = $this->getContent();
    if (is_null($content)) {
      return Craft::$app->getElements()->parseRefs($this->_rawContent);
    }

    $loader = $content->getBatchLoader();
    $replace = [];
    $search = [];
    $str = $this->_parsedContent;

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
