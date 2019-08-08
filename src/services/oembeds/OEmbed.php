<?php

namespace lenz\contentfield\services\oembeds;

use DOMDocument;
use DOMElement;
use lenz\contentfield\helpers\UrlHelper;
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
   * @var array
   */
  protected $_attributes;


  /**
   * @inheritDoc
   */
  public function __get($name) {
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
  public function __set($name, $value) {
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
  public function __isset($name) {
    $getter = 'get' . $name;
    if (method_exists($this, $getter)) {
      return $this->$getter() !== null;
    }

    return array_key_exists($name, $this->_attributes);
  }

  /**
   * @inheritDoc
   */
  public function __unset($name) {
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
   * @param array|null $options
   * @return string
   */
  public function getHtml($options = null) {
    $html = is_string($this->html) ? $this->html : '';

    if (!is_null($options) && !empty($html)) {
      $doc = new DOMDocument();
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


  // Protected methods
  // -----------------

  /**
   * @param DOMElement $element
   * @param array $options
   */
  protected function modifyAttributes(DOMElement $element, array $options) {
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
  protected function modifyQuery(DOMElement $element, array $options) {
    $src = $element->getAttribute('src');
    if (empty($src)) {
      return;
    }

    $url = new UrlHelper($src);
    $query = $url->getQuery();

    foreach ($options as $name => $value) {
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
    $element->setAttribute('src', (string)$url);
  }
}
