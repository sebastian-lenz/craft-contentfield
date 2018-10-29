<?php

namespace contentfield\models\values;

use contentfield\models\Content;
use contentfield\models\fields\AbstractField;
use craft\base\ElementInterface;
use craft\base\Model;

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
  protected $content = null;

  /**
   * @var AbstractField|null
   */
  protected $field;

  /**
   * @var AbstractValue|null
   */
  protected $parent;


  /**
   * AbstractValue constructor.
   *
   * @param AbstractValue|null $parent
   * @param AbstractField|null $field
   */
  public function __construct(AbstractValue $parent = null, AbstractField $field = null) {
    parent::__construct();

    $this->field = $field;
    $this->parent = $parent;
  }

  /**
   * @return string
   */
  abstract function __toString();

  /**
   * @return Content|null
   */
  public function getContent() {
    if (!is_null($this->content)) {
      return $this->content;
    } else if (!is_null($this->parent)) {
      return $this->parent->getContent();
    }

    return null;
  }

  /**
   * Return a list of all referenced entries by this field.
   *
   * @param array $result
   * @return array
   */
  public function getEagerLoadingMap(&$result = array()) {
    return $result;
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
    return $this->field;
  }

  /**
   * @return \Twig_Markup
   */
  abstract function getHtml();

  /**
   * @return AbstractValue|null
   */
  public function getParent() {
    return $this->parent;
  }

  /**
   * @param Content $content
   */
  public function setContent(Content $content) {
    $this->content = $content;
  }
}
