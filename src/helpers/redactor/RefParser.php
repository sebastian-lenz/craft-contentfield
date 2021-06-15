<?php

namespace lenz\contentfield\helpers\redactor;

use Craft;
use craft\base\ElementInterface;
use craft\errors\SiteNotFoundException;
use craft\helpers\StringHelper;
use craft\services\Elements;
use craft\services\Sites;
use Exception;

/**
 * Class RefParser
 */
class RefParser
{
  /**
   * @var string
   */
  public $content = '';

  /**
   * @var int
   */
  public $numMatches = 0;

  /**
   * @var array
   */
  public $tokens = [];

  /**
   * @var int
   */
  private $_defaultSiteId;

  /**
   * @var Elements
   */
  private $_elements;

  /**
   * @var Sites
   */
  private $_sitesService;


  /**
   * RedactorRefParser constructor.
   *
   * @param string $value
   * @throws SiteNotFoundException
   */
  public function __construct(string $value) {
    $this->_defaultSiteId = Craft::$app->getSites()->getCurrentSite()->id;
    $this->_elements = Craft::$app->getElements();
    $this->_sitesService = Craft::$app->getSites();

    $count = 0;
    $this->content = preg_replace_callback(
      '/{([\w\\\\]+):([^@:}]+)(?:@([^:}]+))?(?::([^}| ]+))?(?: *\|\| *([^}]+))?}/',
      $this, $value, -1, $count
    );

    $this->numMatches = $count;
  }

  /**
   * Extracted ref parser from `craft\services\Elements::parseRefs`
   *
   * @param array $matches
   * @return mixed|string
   * @throws Exception
   */
  public function __invoke(array $matches) {
    $matches = array_pad($matches, 6, null);
    [$fullMatch, $elementType, $ref, $siteId, /* $attribute */, $fallback] = $matches;
    if ($fallback === null) {
      $fallback = $fullMatch;
    }

    // Does it already have a full element type class name?
    if (
      !is_subclass_of($elementType, ElementInterface::class) &&
      ($elementType = $this->_elements->getElementTypeByRefHandle($elementType)) === null
    ) {
      return $fallback;
    }

    // Get the site
    if (!empty($siteId)) {
      if (is_numeric($siteId)) {
        $siteId = (int)$siteId;
      } else {
        try {
          if (StringHelper::isUUID($siteId)) {
            $site = $this->_sitesService->getSiteByUid($siteId);
          } else {
            $site = $this->_sitesService->getSiteByHandle($siteId);
          }
        } catch (SiteNotFoundException $e) {
          $site = null;
        }

        if (!$site) {
          return $fallback;
        }

        $siteId = $site->id;
      }
    } else {
      $siteId = $this->_defaultSiteId;
    }

    $token = '{' . StringHelper::randomString(9) . '}';

    // Custom: we currently only support the default site
    if ($siteId != $this->_defaultSiteId) {
      throw new Exception('Unsupported reference source site');
    }

    // Custom: we currently only accept id refs
    if (!is_numeric($ref)) {
      throw new Exception('Unsupported reference type');
    } else {
      $ref = intval($ref);
    }

    $this->tokens[$elementType][$ref][] = [$token, $matches, $fallback, $fullMatch];
    return $token;
  }
}
