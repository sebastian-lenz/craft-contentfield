<?php

namespace contentfield\models\values;

use contentfield\models\fields\ColorField;
use contentfield\models\values\AbstractValue;

/**
 * Class ColorValue
 *
 * @property ColorField $field
 */
class ColorValue extends AbstractValue
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
   * @param AbstractValue $parent
   * @param ColorField $field
   */
  public function __construct($data, AbstractValue $parent, ColorField $field) {
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
   * @return string
   */
  function __toString() {
    return $this->field->disableAlpha
      ? $this->hex()
      : $this->rgba();
  }


  /**
   * Returns the data of this value as required by the cp editor.
   * @return mixed
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
   * @return \Twig_Markup
   */
  function getHtml() {
    return new \Twig_Markup((string)$this, 'utf-8');
  }

  /**
   * @return string
   */
  public function hex() {
    return sprintf("#%02x%02x%02x", $this->red, $this->green, $this->blue);
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
