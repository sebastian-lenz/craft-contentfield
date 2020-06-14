<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use lenz\contentfield\Plugin;

/**
 * Class NumberField
 *
 * Displays a input for entering numbers.
 */
class NumberField extends AbstractNumberField
{
  /**
   * Placeholder text for the text input element. Translated using the default
   * translation method.
   *
   * @var string
   */
  public $placeholder = '';

  /**
   * A unit that will be displayed next to the input field.
   *
   * @var string
   */
  public $unit;

  /**
   * The internal name of this widget.
   */
  const NAME = 'number';


  /**
   * @inheritDoc
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + [
      'placeholder' => $this->getPlaceholder(),
      'unit'        => $this->unit,
    ];
  }

  /**
   * @inheritDoc
   */
  public function rules() {
    return array_merge(
      parent::rules(),
      [
        [['placeholder', 'unit'], 'string']
      ]
    );
  }


  // Private methods
  // ---------------

  /**
   * @return string
   */
  private function getPlaceholder() {
    $placeholder = trim((string)$this->placeholder);

    return empty($placeholder)
      ? ''
      : Plugin::t($placeholder);
  }


  // Static methods
  // --------------

  /**
   * @inheritDoc
   */
  static public function expandFieldConfig(&$config) {
    $type = $config['type'];

    if (array_key_exists($type, AbstractNumberField::DATA_TYPE_ALIASES)) {
      $config['type']     = 'number';
      $config['dataType'] = AbstractNumberField::DATA_TYPE_ALIASES[$type];
    }
  }
}
