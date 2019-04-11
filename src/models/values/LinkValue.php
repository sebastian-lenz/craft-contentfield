<?php

namespace sebastianlenz\contentfield\models\values;

use sebastianlenz\contentfield\models\fields\LinkField;
use craft\base\ElementInterface;
use craft\elements\Entry;
use craft\helpers\Html;
use craft\helpers\Template;
use sebastianlenz\contentfield\utilities\ReferenceMap;

/**
 * Class LinkValue
 *
 * @property LinkField $__field
 */
class LinkValue extends AbstractValue
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
  private $element;


  /**
   * LinkValue constructor.
   *
   * @param mixed $data
   * @param AbstractValue $parent
   * @param LinkField $field
   */
  public function __construct($data, AbstractValue $parent, LinkField $field) {
    parent::__construct($parent, $field);

    if (is_array($data)) {
      if (is_numeric($data['elementId'])) {
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
   * Returns the data of this value as required by the cp editor.
   * @return mixed
   */
  function getEditorData() {
    return array(
      'elementId'       => $this->elementId,
      'openInNewWindow' => $this->openInNewWindow,
      'type'            => $this->type,
      'url'             => $this->url,
    );
  }

  /**
   * @return null|string
   */
  public function getElementType() {
    $linkType = $this->getLinkType();
    return !is_null($linkType) && $linkType['type'] === 'element'
      ? $linkType['elementType']
      : null;
  }

  /**
   * @return \Twig_Markup
   */
  function getHtml() {
    return new \Twig_Markup((string)$this, 'utf-8');
  }

  /**
   * @return ElementInterface|null
   */
  function getLinkedElement() {
    if (!isset($this->element)) {
      if (!$this->hasLinkedElement()) {
        $this->element = null;
      } else {
        $elementType = $this->getElementType();
        $elementId = $this->elementId;
        $content = $this->getContent();

        if (!is_null($content)) {
          $this->element = $content->getBatchLoader()->getElement($elementType, $elementId);
        } else {
          /** @var ElementInterface $elementType */
          $this->element = $elementType::findOne(array(
            'id' => $elementId,
          ));
        }
      }
    }

    return $this->element;
  }

  /**
   * @return array|null
   */
  function getLinkType() {
    return array_key_exists($this->type, $this->__field->linkTypes)
      ? $this->__field->linkTypes[$this->type]
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
