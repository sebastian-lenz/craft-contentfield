<?php

namespace lenz\contentfield\helpers\redactor;

use Craft;
use craft\base\ElementInterface;
use craft\errors\SiteNotFoundException;
use craft\helpers\StringHelper;
use Exception;
use Throwable;

/**
 * class Token
 */
class Token
{
  public string $fullMatch;
  public string $placeholder;
  public string $elementType;
  public int $ref;
  public int $siteId;
  public ?string $attribute;
  public string $fallback;


  /**
   * @param string[] $match
   * @throws Exception
   */
  public function __construct(array $match) {
    $match = array_pad($match, 6, null);

    $this->placeholder = '{' . StringHelper::randomString(9) . '}';
    $this->fullMatch = $match[0];
    $this->elementType = self::parseElementType($match[1]);
    $this->ref = self::parseRef($match[2]);
    $this->siteId = self::parseSiteId($match[3]);
    $this->attribute = $match[4];
    $this->fallback = self::getFallback($match);
  }

  /**
   * Returns the replacement for a given reference tag.
   *
   * @param ElementInterface|null $element
   * @return string
   * @throws Exception
   */
  public function getReplacement(?ElementInterface $element): string {
    // Put the ref tag back
    if (is_null($element)) {
      return $this->fullMatch;
    }

    // Default to the URL
    if (empty($this->attribute)) {
      return (string)$element->getUrl();
    }

    try {
      $value = $element->{$this->attribute};
      if (is_object($value) && !method_exists($value, '__toString')) {
        throw new Exception('Object of class ' . get_class($value) . ' could not be converted to string');
      }

      return Craft::$app->getElements()->parseRefs((string)$value);
    } catch (Throwable $e) {
      // Log it
      Craft::error('An exception was thrown when parsing the ref tag "' . $this->fullMatch . "\":\n" . $e->getMessage(), __METHOD__);
    }

    // Replace the token with the original ref tag
    return $this->fullMatch;
  }


  // Static methods
  // --------------

  /**
   * @param array $match
   * @return string
   */
  static public function getFallback(array $match): string {
    return is_null($match[5]) ? $match[0] : $match[5];
  }


  // Static private methods
  // ----------------------

  /**
   * @param string $value
   * @return string
   * @throws Exception
   */
  static private function parseElementType(string $value): string {
    if (is_subclass_of($value, ElementInterface::class)) {
      return $value;
    }

    $value = Craft::$app->getElements()->getElementTypeByRefHandle($value);
    if (is_null($value)) {
      throw new Exception("Invalid element type: $value");
    }

    return $value;
  }

  /**
   * @param string $value
   * @return int
   * @throws Exception
   */
  static private function parseRef(string $value): int {
    if (!is_numeric($value)) {
      throw new Exception('Unsupported reference type');
    }

    return intval($value);
  }

  /**
   * @param string $value
   * @return int|null
   * @throws SiteNotFoundException
   */
  static private function parseSiteId(string $value): ?int {
    $sites = Craft::$app->getSites();
    if (is_numeric($value)) {
      return (int)$value;
    }

    if (empty($value)) {
      $site = $sites->getCurrentSite();
    } elseif (StringHelper::isUUID($value)) {
      $site = $sites->getSiteByUid($value);
    } else {
      $site = $sites->getSiteByHandle($value);
    }

    return $site->id;
  }
}
