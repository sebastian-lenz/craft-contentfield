<?php

namespace lenz\contentfield\models\fields;

use lenz\contentfield\models\values\ColorValue;
use lenz\contentfield\models\values\ValueInterface;
use craft\base\ElementInterface;

/**
 * Class ColorField
 */
class ColorField extends AbstractField
{
  /**
   * @var bool
   */
  public $disableAlpha = true;

  /**
   * @var array
   */
  public $presetColors = null;

  /**
   * @inheritdoc
   */
  const NAME = 'color';


  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent) {
    return new ColorValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + array(
      'disableAlpha' => $this->disableAlpha,
      'presetColors' => $this->presetColors,
    );
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue($value) {
    if (!($value instanceof ColorValue)) {
      return null;
    }

    return array(
      'alpha' => $value->alpha,
      'blue'  => $value->blue,
      'green' => $value->green,
      'red'   => $value->red,
    );
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return array_merge(
      parent::rules(),
      array(
        array('presetColors', 'validatePresetColors'),
      )
    );
  }

  /**
   * @param $attribute
   */
  public function validatePresetColors($attribute) {
    if (!isset($this->$attribute) || empty($this->$attribute)) {
      return;
    }

    if (!is_array($this->$attribute)) {
      $this->addError($attribute, "{$attribute} must be an array.");
      return;
    }

    $hasInvalidValue = false;
    foreach ($this->$attribute as $value) {
      if (!self::isHexColor($value)) {
        $hasInvalidValue = true;
        break;
      }
    }

    if ($hasInvalidValue) {
      $this->addError($attribute, implode(' ', array(
        "{$attribute} contains invalid values.",
        "All values must be either a hex color string or an",
        "object containing 'color' and 'title'."
      )));
    }
  }

  /**
   * @param string $value
   * @return false|int
   */
  static public function isHexColor($value) {
    return preg_match('/#([a-f0-9]{3}){1,2}\b/i', $value);
  }
}
