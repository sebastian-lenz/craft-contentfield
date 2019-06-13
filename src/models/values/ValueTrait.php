<?php

namespace lenz\contentfield\models\values;

use craft\base\ElementInterface;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\utilities\ReferenceMap;
use Twig\Markup;

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
   * @return Markup
   */
  public function getHtml() {
    return new Markup((string)$this, 'utf-8');
  }

  /**
   * @return ValueInterface|null
   */
  public function getParent() {
    return $this->_parent;
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
