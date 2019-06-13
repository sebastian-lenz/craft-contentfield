<?php

namespace lenz\contentfield\models\values;

use lenz\contentfield\models\fields\ColorField;
use lenz\contentfield\models\values\ValueInterface;

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
  function __toString() {
    return $this->_field->disableAlpha
      ? $this->hex()
      : $this->rgba();
  }


  /**
   * @inheritDoc
   */
  function getEditorData() {
    return array(
      'alpha' => $this->alpha,
      'blue'  => $this->blue,
      'green' => $this->green,
      'red'   => $this->red,
    );
  }

  /**
   * @return string
   */
  public function hex() {
    return sprintf("#%02x%02x%02x", $this->red, $this->green, $this->blue);
  }

  /**
   * @inheritDoc
   */
  public function isEmpty() {
    return false;
  }

  /**
   * @return string
   */
  public function rgba() {
    return 'rgba(' . implode(',', array(
      $this->red,
      $this->green,
      $this->blue,
      $this->alpha,
    )) . ')';
  }
}
