<?php

namespace lenz\contentfield\models\values;

use craft\base\ElementInterface;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\utilities\ReferenceMap;
use Twig\Markup;

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
   * @param string $uuid
   * @return InstanceValue|null
   */
  public function findUuid(string $uuid);

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
   * @return Markup
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
