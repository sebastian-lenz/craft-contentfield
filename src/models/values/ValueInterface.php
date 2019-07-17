<?php

namespace lenz\contentfield\models\values;

use craft\base\ElementInterface;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\fields\AbstractField;
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
   * @return Content|null
   */
  public function getContent();

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
