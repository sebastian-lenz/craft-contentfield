<?php

namespace lenz\contentfield\models\values;

use craft\base\ElementInterface;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\fields\AbstractField;
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
  public function getContent(): ?Content {
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
  public function getElement(): ?ElementInterface {
    $content = $this->getContent();
    return is_null($content) ? null : $content->getOwner();
  }

  /**
   * @return AbstractField|null
   */
  public function getField(): ?AbstractField {
    return $this->_field;
  }

  /**
   * @return Markup
   */
  public function getHtml(): Markup {
    return new Markup((string)$this, 'utf-8');
  }

  /**
   * @return ValueInterface|null
   */
  public function getParent(): ?ValueInterface {
    return $this->_parent;
  }

  /**
   * @return ValueInterface|null
   */
  public function getRoot(): ?ValueInterface {
    if (!is_null($this->_parent)) {
      return $this->_parent->getRoot();
    }

    return $this instanceof ValueInterface ? $this : null;
  }

  /**
   * @return bool
   */
  public function hasValue(): bool {
    return !$this->isEmpty();
  }

  /**
   * @return bool
   */
  abstract function isEmpty(): bool;

  /**
   * @param Content $content
   */
  public function setContent(Content $content) {
    $this->_content = $content;
  }
}
