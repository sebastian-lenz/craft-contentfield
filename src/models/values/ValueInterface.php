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
  public function getContent(): ?Content;

  /**
   * @return ElementInterface|null
   */
  public function getElement(): ?ElementInterface;

  /**
   * @return AbstractField|null
   */
  public function getField(): ?AbstractField;

  /**
   * @return Markup
   */
  public function getHtml(): Markup;

  /**
   * @return ValueInterface|null
   */
  public function getParent(): ?ValueInterface;

  /**
   * @return ValueInterface|null
   */
  public function getRoot(): ?ValueInterface;

  /**
   * @return bool
   */
  public function hasValue(): bool;

  /**
   * @return bool
   */
  public function isEmpty(): bool;

  /**
   * @param Content $content
   */
  public function setContent(Content $content);
}
