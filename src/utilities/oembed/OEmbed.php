<?php

namespace contentfield\utilities\oembed;

use craft\helpers\Json;
use yii\caching\FileCache;

/**
 * Class OEmbed
 */
class OEmbed
{
  /**
   * The resource type. Valid values, along with value-specific parameters, are described below.
   * @var string
   */
  public $type;

  /**
   * The oEmbed version number. This must be 1.0.
   * @var string
   */
  public $version;

  /**
   * A text title, describing the resource.
   * @var string
   */
  public $title;

  /**
   * The name of the author/owner of the resource.
   * @var string
   */
  public $author_name;

  /**
   * A URL for the author/owner of the resource.
   * @var string
   */
  public $author_url;

  /**
   * The name of the resource provider.
   * @var string
   */
  public $provider_name;

  /**
   * The url of the resource provider.
   * @var string
   */
  public $provider_url;

  /**
   * The suggested cache lifetime for this resource, in seconds. Consumers
   * may choose to use this value or not.
   * @var integer
   */
  public $cache_age;

  /**
   * A URL to a thumbnail image representing the resource. The thumbnail
   * must respect any maxwidth and maxheight parameters. If this parameter
   * is present, thumbnail_width and thumbnail_height must also be present.
   * @var string
   */
  public $thumbnail_url;

  /**
   * The width of the optional thumbnail. If this parameter is present,
   * thumbnail_url and thumbnail_height must also be present.
   * @var integer
   */
  public $thumbnail_width;

  /**
   * The height of the optional thumbnail. If this parameter is present,
   * thumbnail_url and thumbnail_width must also be present.
   * @var integer
   */
  public $thumbnail_height;

  /**
   * The HTML required to embed a video player. The HTML should have no
   * padding or margins.
   * @var string
   */
  public $html;

  /**
   * The width in pixels required to display the HTML.
   * @var integer
   */
  public $width;

  /**
   * The height in pixels required to display the HTML.
   * @var integer
   */
  public $height;


  /**
   * @var FileCache
   */
  private static $cache;

  /**
   * Default cache duration.
   */
  const CACHE_DURATION = 60 * 60 * 24 * 30;


  /**
   * OEmbed constructor.
   * @param array $data
   */
  public function __construct($data) {
    \Yii::configure($this, $data);
  }

  /**
   * @return array
   */
  public function getEditorData() {
    return array();
  }

  /**
   * @param array|null $options
   * @return string
   */
  public function getHtml($options = null) {
    $html = is_string($this->html) ? $this->html : '';

    if (!is_null($options) && !empty($html)) {
      $doc = new \DOMDocument();
      $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED);
      $element = $doc->documentElement;

      if (isset($options['attributes'])) {
        $this->modifyAttributes($element, $options['attributes']);
      }

      if (isset($options['query'])) {
        $this->modifyQuery($element, $options['query']);
      }

      $html = $doc->saveHTML($element);
    }

    return $html;
  }

  /**
   * @param \DOMElement $element
   * @param array $options
   */
  protected function modifyAttributes(\DOMElement $element, array $options) {
    foreach ($options as $name => $value) {
      if (is_null($value)) {
        $element->removeAttribute($name);
      } elseif (is_array($value) && isset($value['rename'])) {
        $attribute = $element->getAttribute($name);
        $element->removeAttribute($name);
        $element->setAttribute($value['rename'], $attribute);
      } else {
        $element->setAttribute($name, $value);
      }
    }
  }

  /**
   * @param \DOMElement $element
   * @param array $options
   */
  protected function modifyQuery(\DOMElement $element, array $options) {
    $src = $element->getAttribute('src');
    if (empty($src)) {
      return;
    }

    $url = new \contentfield\utilities\Url($src);
    $query = $url->getQuery();

    foreach ($options as $name => $value) {
      if (is_null($value)) {
        unset($query[$name]);
      } else {
        $query[$name] = $value;
      }
    }

    $url->setQuery($query);
    $element->setAttribute('src', (string)$url);
  }

  /**
   * @param string $url
   * @return array|null
   */
  static public function fetchJson($url) {
    $cache = self::getCache();
    $result = null;

    try {
      $response = $cache->get($url);
      if ($response !== false) {
        $result = Json::decode($response);
      }
    } catch (\Throwable $error) {}

    if (is_null($result)) {
      try {
        $response = file_get_contents($url);
        $result = Json::decode($response);
        $duration = isset($result['cache_age']) ? $result['cache_age'] : self::CACHE_DURATION;
        $cache->set($url, $response, $duration);
      } catch (\Throwable $error) {}
    }

    return is_array($result) ? $result : null;
  }

  /**
   * @return FileCache
   */
  static public function getCache() {
    if (!isset(self::$cache)) {
      self::$cache = new FileCache([
        'cachePath' => '@runtime/oembed'
      ]);
    }

    return self::$cache;
  }
}
