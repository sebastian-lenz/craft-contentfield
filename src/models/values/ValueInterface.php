<?php

namespace sebastianlenz\contentfield\models\values;

use craft\base\ElementInterface;
use sebastianlenz\contentfield\models\Content;
use sebastianlenz\contentfield\models\fields\AbstractField;
use sebastianlenz\contentfield\utilities\ReferenceMap;

/**
 * Interface ValueInterface
 */
interface ValueInterface
{
  /**
   * @return string
   */
  public function __toString();

  /**
   * @param string|string[] $qualifier
   * @return InstanceValue[]
   */
  public function findInstances($qualifier);

  /**
   * @return Content|null
   */
  public function getContent();

  /**
   * Returns the data of this value as required by the cp editor.
   * @return mixed
   */
  public function getEditorData();

  /**
   * @return ElementInterface|null
   */
  public function getElement();

  /**
   * @return AbstractField|null
   */
  public function getField();

  /**
   * @return \Twig_Markup
   */
  public function getHtml();

  /**
   * @return ValueInterface|null
   */
  public function getParent();

  /**
   * Return a list of all referenced entries by this field.
   *
   * @param ReferenceMap $map
   * @return ReferenceMap
   */
  public function getReferenceMap(ReferenceMap $map = null);

  /**
   * @return string
   */
  public function getSearchKeywords();

  /**
   * Returns the data of this value for storing in the database. By default,
   * this is the same as `$this->getEditorData()`.
   * @return mixed
   */
  public function getSerializedData();

  /**
   * @return bool
   */
  public function hasValue();

  /**
   * @return bool
   */
  public function isEmpty();

  /**
   * @param Content $content
   */
  public function setContent(Content $content);
}
