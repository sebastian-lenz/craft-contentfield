<?php

namespace lenz\contentfield\models\values;

use lenz\contentfield\models\fields\ColorField;

/**
 * Class ColorValue
 *
 * @property ColorField $_field
 */
class ColorValue extends Value
{
  /**
   * @var float
   */
  public $alpha = 1;

  /**
   * @var int
   */
  public $blue = 255;

  /**
   * @var int
   */
  public $green = 255;

  /**
   * @var int
   */
  public $red = 255;


  /**
   * ColorValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface $parent
   * @param ColorField $field
   */
  public function __construct($data, ValueInterface $parent, ColorField $field) {
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
  public function __toString() {
    return $this->getCssValue();
  }

  /**
   * @return string
   */
  public function getCssValue() {
    return $this->_field->alpha
      ? $this->getRgba()
      : $this->getHex();
  }

  /**
   * @return string
   */
  public function getHex() {
    return sprintf("#%02x%02x%02x", $this->red, $this->green, $this->blue);
  }

  /**
   * @param float|null $alpha
   * @return string
   */
  public function getRgba($alpha = null) {
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
  public function isEmpty() {
    return false;
  }
}
