<?php

namespace lenz\contentfield\models\values;

use craft\base\ElementInterface;
use craft\helpers\Html;
use craft\helpers\Template;
use Exception;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\models\fields\LinkField;

/**
 * Class LinkValue
 *
 * @property LinkField $_field
 */
class LinkValue extends Value implements ReferenceMapValueInterface
{
  /**
   * @var int
   */
  public $elementId = 0;

  /**
   * @var bool
   */
  public $openInNewWindow = false;

  /**
   * @var string
   */
  public $type = '';

  /**
   * @var string
   */
  public $url = '';

  /**
   * @var ElementInterface|null
   */
  private $_element;


  /**
   * LinkValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface $parent
   * @param LinkField $field
   */
  public function __construct($data, ValueInterface $parent, LinkField $field) {
    parent::__construct($parent, $field);

    if (is_array($data)) {
      if (isset($data['elementId']) && is_numeric($data['elementId'])) {
        $this->elementId = $data['elementId'];
      }

      if (isset($data['type'])) {
        $this->type = $data['type'];
      }

      if (isset($data['url'])) {
        $this->url = $data['url'];
      }

      if (isset($data['openInNewWindow'])) {
        $this->openInNewWindow = !!$data['openInNewWindow'];
      }
    }
  }

  /**
   * @return string
   * @throws Exception
   */
  function __toString() {
    switch ($this->type) {
      case 'url':
        return $this->url;
      case 'mail':
        return 'mailto:' . $this->url;
      default:
        $element = $this->getLinkedElement();
        return is_null($element) ? '' : $element->getUrl();
    }
  }

  /**
   * @param array $extraAttribs
   * @return string
   * @throws Exception
   */
  public function getLinkAttributes($extraAttribs = array()) {
    if ($this->isEmpty()) {
      return '';
    }

    $attribs = [
      'href' => $this->getUrl(),
    ] + $extraAttribs;

    if ($this->openInNewWindow) {
      $attribs['target'] = '_blank';
    }

    return Template::raw(Html::renderTagAttributes($attribs));
  }

  /**
   * @return null|string
   */
  public function getElementType() {
    $linkType = $this->getLinkType();
    return !is_null($linkType) && $linkType['type'] === 'element'
      ? ReferenceMap::normalizeElementType($linkType['elementType'])
      : null;
  }

  /**
   * @return ElementInterface|null
   * @throws Exception
   */
  function getLinkedElement() {
    if (!isset($this->_element)) {
      if (!$this->hasLinkedElement()) {
        $this->_element = null;
      } else {
        $elementType = $this->getElementType();
        $elementId = $this->elementId;
        $content = $this->getContent();

        if (!is_null($content)) {
          $this->_element = $content
            ->getReferenceLoader()
            ->getElement($elementType, $elementId);
        } else {
          /** @var ElementInterface $elementType */
          $this->_element = $elementType::findOne(array(
            'id' => $elementId,
          ));
        }
      }
    }

    return $this->_element;
  }

  /**
   * @return array|null
   */
  function getLinkType() {
    return array_key_exists($this->type, $this->_field->linkTypes)
      ? $this->_field->linkTypes[$this->type]
      : null;
  }

  /**
   * @inheritdoc
   */
  public function getReferenceMap(ReferenceMap $map = null) {
    if (is_null($map)) {
      $map = new ReferenceMap();
    }

    if ($this->hasLinkedElement()) {
      $map->push($this->getElementType(), $this->elementId);
    }

    return $map;
  }

  /**
   * @return string
   */
  function getUrl() {
    return (string)$this;
  }

  /**
   * @return bool
   */
  function hasLinkedElement() {
    $elementType = $this->getElementType();
    return (
      !is_null($elementType) &&
      is_numeric($this->elementId) &&
      $this->elementId !== 0
    );
  }

  /**
   * @return bool
   * @throws Exception
   */
  public function isEmpty() {
    $linkType = $this->getLinkType();
    if (is_null($linkType)) {
      return true;
    }

    return $linkType['type'] === 'element'
      ? is_null($this->getLinkedElement())
      : empty($this->url);
  }
}
