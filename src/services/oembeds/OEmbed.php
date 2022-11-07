<?php

/** @noinspection PhpUnused */

namespace lenz\contentfield\services\oembeds;

use DOMDocument;
use DOMElement;
use lenz\craft\utils\models\Url;
use Throwable;
use yii\base\BaseObject;
use yii\base\InvalidCallException;
use yii\base\UnknownPropertyException;

/**
 * Class OEmbed
 *
 * Represents a single embeddable resource.
 */
class OEmbed extends BaseObject
{
  /**
   * The resource type. Valid values, along with value-specific parameters, are described below.
   * @var string
   */
  public string $type = '';

  /**
   * The oEmbed version number. This must be 1.0.
   * @var string
   */
  public string $version = '';

  /**
   * A text title, describing the resource.
   * @var string
   */
  public string $title = '';

  /**
   * The name of the author/owner of the resource.
   * @var string
   */
  public string $author_name = '';

  /**
   * A URL for the author/owner of the resource.
   * @var string
   */
  public string $author_url = '';

  /**
   * The name of the resource provider.
   * @var string
   */
  public string $provider_name = '';

  /**
   * The url of the resource provider.
   * @var string
   */
  public string $provider_url = '';

  /**
   * The suggested cache lifetime for this resource, in seconds. Consumers
   * may choose to use this value or not.
   * @var integer
   */
  public int $cache_age = 0;

  /**
   * A URL to a thumbnail image representing the resource. The thumbnail
   * must respect any maxwidth and maxheight parameters. If this parameter
   * is present, thumbnail_width and thumbnail_height must also be present.
   * @var string
   */
  public string $thumbnail_url = '';

  /**
   * The width of the optional thumbnail. If this parameter is present,
   * thumbnail_url and thumbnail_height must also be present.
   * @var int
   */
  public int $thumbnail_width = 0;

  /**
   * The height of the optional thumbnail. If this parameter is present,
   * thumbnail_url and thumbnail_width must also be present.
   * @var int
   */
  public int $thumbnail_height = 0;

  /**
   * The HTML required to embed a video player. The HTML should have no
   * padding or margins.
   * @var string
   */
  public string $html = '';

  /**
   * The width in pixels required to display the HTML.
   * @var string|int
   */
  public string|int $width = 0;

  /**
   * The height in pixels required to display the HTML.
   * @var string|int
   */
  public string|int $height = 0;

  /**
   * @var array
   */
  protected array $_attributes = [];

  /**
   * @var Endpoint
   */
  protected Endpoint $_endpoint;

  /**
   * @var string
   */
  protected string $_originalUrl;


  /**
   * OEmbed constructor.
   *
   * @param Endpoint $endpoint
   * @param string $originalUrl
   * @param array $config
   */
  public function __construct(Endpoint $endpoint, string $originalUrl, array $config = []) {
    parent::__construct($config);

    $this->_endpoint = $endpoint;
    $this->_originalUrl = $originalUrl;
  }

  /**
   * @inheritDoc
   */
  public function __get($name): mixed {
    $getter = 'get' . $name;
    if (method_exists($this, $getter)) {
      return $this->$getter();
    } elseif (method_exists($this, 'set' . $name)) {
      throw new InvalidCallException('Getting write-only property: ' . get_class($this) . '::' . $name);
    }

    if (array_key_exists($name, $this->_attributes)) {
      return $this->_attributes[$name];
    }

    throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
  }

  /**
   * @inheritDoc
   */
  public function __set($name, $value): void {
    $setter = 'set' . $name;
    if (method_exists($this, $setter)) {
      $this->$setter($value);
    } elseif (method_exists($this, 'get' . $name)) {
      throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::' . $name);
    } else {
      $this->_attributes[$name] = $value;
    }
  }

  /**
   * @inheritDoc
   */
  public function __isset($name): bool {
    $getter = 'get' . $name;
    if (method_exists($this, $getter)) {
      return $this->$getter() !== null;
    }

    return array_key_exists($name, $this->_attributes);
  }

  /**
   * @inheritDoc
   */
  public function __unset($name) : void{
    $setter = 'set' . $name;
    if (method_exists($this, $setter)) {
      $this->$setter(null);
    } elseif (method_exists($this, 'get' . $name)) {
      throw new InvalidCallException('Unsetting read-only property: ' . get_class($this) . '::' . $name);
    } else {
      unset($this->_attributes);
    }
  }

  /**
   * @return Endpoint
   */
  public function getEndpoint(): Endpoint {
    return $this->_endpoint;
  }

  /**
   * @return string
   * @noinspection PhpUnused
   */
  public function getOriginalUrl(): string {
    return $this->_originalUrl;
  }

  /**
   * @param array|null $options
   * @return string
   */
  public function getHtml(array $options = null): string {
    $html = $this->html;

    if (!is_null($options) && !empty($html)) {
      $oldErrorMode = libxml_use_internal_errors(true);

      try {
        $doc = new DOMDocument();
        $doc->loadHTML($html, constant('LIBXML_HTML_NOIMPLIED'));
        $element = $doc->documentElement;

        if (isset($options['attributes'])) {
          $this->modifyAttributes($element, $options['attributes']);
        }

        $this->modifyQuery($element, $options);
        $html = $doc->saveHTML($element);
      } catch (Throwable) {
        // Just ignore this error
      } finally {
        libxml_use_internal_errors($oldErrorMode);
      }
    }

    return $html;
  }


  // Protected methods
  // -----------------

  /**
   * @param DOMElement $element
   * @param array $options
   */
  protected function modifyAttributes(DOMElement $element, array $options): void {
    foreach ($options as $name => $value) {
      if (is_null($value)) {
        $element->removeAttribute($name);
      } elseif (is_array($value) && isset($value['rename'])) {
        if ($element->hasAttribute($name)) {
          $attribute = $element->getAttribute($name);
          $element->removeAttribute($name);
          $element->setAttribute($value['rename'], $attribute);
        }
      } else {
        $element->setAttribute($name, $value);
      }
    }
  }

  /**
   * @param DOMElement $element
   * @param array $options
   */
  protected function modifyQuery(DOMElement $element, array $options): void {
    $src = $element->getAttribute('src');
    if (empty($src)) {
      return;
    }

    $url = new Url($src);
    $this->modifyUrl($url, $options);
    $element->setAttribute('src', (string)$url);
  }

  /**
   * @param Url $url
   * @param array $options
   */
  protected function modifyUrl(Url $url, array $options): void {
    if (!isset($options['query'])) {
      return;
    }

    $query = $url->getQuery();
    foreach ($options['query'] as $name => $value) {
      if (is_null($value)) {
        unset($query[$name]);
      } elseif (is_array($value) && isset($value['rename'])) {
        if (isset($query[$name])) {
          $attribute = $query[$name];
          unset($query[$name]);
          $query[$value['rename']] = $attribute;
        }
      } else {
        $query[$name] = $value;
      }
    }

    $url->setQuery($query);
  }
}
