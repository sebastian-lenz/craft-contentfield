<?php

namespace sebastianlenz\contentfield\models\values;

use craft\base\ElementInterface;
use sebastianlenz\contentfield\models\Content;
use sebastianlenz\contentfield\models\fields\AbstractField;
use sebastianlenz\contentfield\utilities\ReferenceMap;

/**
 * Trait ValueTrait
 */
trait ValueTrait
{
  /**
   * @var Content|null
   */
  protected $_content = null;

  /**
   * @var AbstractField|null
   */
  protected $_field;

  /**
   * @var ValueInterface|null
   */
  protected $_parent;


  /**
   * @return string
   */
  abstract function __toString();

  /**
   * @param string|string[] $qualifier
   * @return InstanceValue[]
   */
  public function findInstances($qualifier) {
    return array();
  }

  /**
   * @return Content|null
   */
  public function getContent() {
    if (!is_null($this->_content)) {
      return $this->_content;
    } else if (!is_null($this->_parent)) {
      return $this->_parent->getContent();
    }

    return null;
  }

  /**
   * Returns the data of this value as required by the cp editor.
   * @return mixed
   */
  abstract function getEditorData();

  /**
   * @return ElementInterface|null
   */
  public function getElement() {
    $content = $this->getContent();
    return is_null($content) ? null : $content->getOwner();
  }

  /**
   * @return AbstractField|null
   */
  public function getField() {
    return $this->_field;
  }

  /**
   * @return \Twig_Markup
   */
  public function getHtml() {
    return new \Twig_Markup((string)$this, 'utf-8');
  }

  /**
   * @return ValueInterface|null
   */
  public function getParent() {
    return $this->_parent;
  }

  /**
   * Return a list of all referenced entries by this field.
   *
   * @param ReferenceMap $map
   * @return ReferenceMap
   */
  public function getReferenceMap(ReferenceMap $map = null) {
    return is_null($map)
      ? new ReferenceMap()
      : $map;
  }

  /**
   * @return string
   */
  public function getSearchKeywords() {
    return '';
  }

  /**
   * Returns the data of this value for storing in the database. By default,
   * this is the same as `$this->getEditorData()`.
   * @return mixed
   */
  public function getSerializedData() {
    return $this->getEditorData();
  }

  /**
   * @return bool
   */
  public function hasValue() {
    return !$this->isEmpty();
  }

  /**
   * @return bool
   */
  abstract function isEmpty();

  /**
   * @param Content $content
   */
  public function setContent(Content $content) {
    $this->_content = $content;
  }
}
