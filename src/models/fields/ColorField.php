<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use lenz\contentfield\models\values\ColorValue;
use lenz\contentfield\models\values\ValueInterface;

/**
 * Class ColorField
 */
class ColorField extends AbstractField
{
  /**
   * @var bool
   */
  public bool $alpha = false;

  /**
   * @var array|null
   */
  public ?array $swatches = null;

  /**
   * @inheritdoc
   */
  const NAME = 'color';


  /**
   * @inheritdoc
   */
  public function createValue(mixed $data, ValueInterface $parent = null): ColorValue {
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
  public function getEditorValue(mixed $value): ?array {
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
    if (empty($this->$attribute)) {
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
    return !!preg_match('/#([a-f\d]{3}){1,2}\b/i', $value);
  }
}
