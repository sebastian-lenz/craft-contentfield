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
  public $alpha = false;

  /**
   * @var array
   */
  public $swatches = null;

  /**
   * @inheritdoc
   */
  const NAME = 'color';


  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent = null) {
    return new ColorValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null): array {
    return parent::getEditorData($element) + [
      'alpha'    => $this->alpha,
      'swatches' => $this->swatches,
    ];
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue($value) {
    if (!($value instanceof ColorValue)) {
      return null;
    }

    return [
      'alpha' => $value->alpha,
      'blue'  => $value->blue,
      'green' => $value->green,
      'red'   => $value->red,
    ];
  }

  /**
   * @inheritdoc
   */
  public function rules(): array {
    return array_merge(
      parent::rules(),
      [
        ['alpha', 'required'],
        ['alpha', 'boolean'],
        ['swatches', 'validateSwatches'],
      ]
    );
  }

  /**
   * @param string $attribute
   * @noinspection PhpUnused (Validator)
   */
  public function validateSwatches(string $attribute) {
    if (!isset($this->$attribute) || empty($this->$attribute)) {
      return;
    }

    if (!is_array($this->$attribute)) {
      $this->addError($attribute, "$attribute must be an array.");
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
      $this->addError($attribute, implode(' ', [
        "$attribute contains invalid values.",
        "All values must be either a hex color string."
      ]));
    }
  }


  // Static methods
  // --------------

  /**
   * @param string $value
   * @return bool
   */
  static public function isHexColor(string $value): bool {
    return !!preg_match('/#([a-f0-9]{3}){1,2}\b/i', $value);
  }
}
