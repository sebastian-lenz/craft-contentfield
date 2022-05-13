<?php

namespace lenz\contentfield\models\values;

use lenz\contentfield\models\fields\ColorField;

/**
 * Class ColorValue
 *
 * @property ColorField $_field
 */
class ColorValue extends AbstractValue
{
  /**
   * @var float
   */
  public mixed $alpha = 1;

  /**
   * @var int
   */
  public mixed $blue = 255;

  /**
   * @var int
   */
  public mixed $green = 255;

  /**
   * @var int
   */
  public mixed $red = 255;


  /**
   * ColorValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface|null $parent
   * @param ColorField|null $field
   */
  public function __construct($data, ValueInterface $parent = null, ColorField $field = null) {
    parent::__construct($parent, $field);

    if (is_array($data)) {
      if (is_numeric($data['alpha'])) {
        $this->alpha = max(0, min(1, $data['alpha']));
      }

      if (is_numeric($data['blue'])) {
        $this->blue = max(0, min(255, intval($data['blue'])));
      }

      if (is_numeric($data['green'])) {
        $this->green = max(0, min(255, intval($data['green'])));
      }

      if (is_numeric($data['red'])) {
        $this->red = max(0, min(255, intval($data['red'])));
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function __toString(): string {
    return $this->getCssValue();
  }

  /**
   * @return string
   */
  public function getCssValue(): string {
    return $this->_field->alpha
      ? $this->getRgba()
      : $this->getHex();
  }

  /**
   * @return string
   */
  public function getHex(): string {
    return sprintf("#%02x%02x%02x", $this->red, $this->green, $this->blue);
  }

  /**
   * @param float|null $alpha
   * @return string
   */
  public function getRgba(float $alpha = null): string {
    return 'rgba(' . implode(',', array(
        $this->red,
        $this->green,
        $this->blue,
        is_null($alpha) ? $this->alpha : $alpha,
      )) . ')';
  }

  /**
   * @inheritDoc
   */
  public function isEmpty(): bool {
    return false;
  }
}
