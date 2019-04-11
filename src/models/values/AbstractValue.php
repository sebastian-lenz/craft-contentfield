<?php

namespace sebastianlenz\contentfield\models\values;

use sebastianlenz\contentfield\models\Content;
use sebastianlenz\contentfield\models\fields\AbstractField;
use craft\base\ElementInterface;
use craft\base\Model;
use sebastianlenz\contentfield\utilities\ReferenceMap;

/**
 * Class AbstractValue
 *
 * Base class of all values.
 */
abstract class AbstractValue extends Model
{
  /**
   * @var Content|null
   */
  protected $__content = null;

  /**
   * @var AbstractField|null
   */
  protected $__field;

  /**
   * @var AbstractValue|null
   */
  protected $__parent;


  /**
   * AbstractValue constructor.
   *
   * @param AbstractValue|null $parent
   * @param AbstractField|null $field
   */
  public function __construct(AbstractValue $parent = null, AbstractField $field = null) {
    parent::__construct();

    $this->__field = $field;
    $this->__parent = $parent;
  }

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
    if (!is_null($this->__content)) {
      return $this->__content;
    } else if (!is_null($this->__parent)) {
      return $this->__parent->getContent();
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
    return $this->__field;
  }

  /**
   * @return \Twig_Markup
   */
  abstract function getHtml();

  /**
   * @return AbstractValue|null
   */
  public function getParent() {
    return $this->__parent;
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
    $this->__content = $content;
  }
}
