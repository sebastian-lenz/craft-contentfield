<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use lenz\contentfield\Plugin;

/**
 * Class TextField
 *
 * Displays a simple text input.
 */
class TextField extends AbstractStringField
{
  /**
   * Input type of the html input element, e.g. `email`, `text` or `url`.
   *
   * @var string
   */
  public string $inputType = 'text';

  /**
   * Placeholder text for the text input element. Translated using the default
   * translation method.
   *
   * @var string
   */
  public string $placeholder = '';

  /**
   * The internal name of this widget.
   */
  const NAME = 'text';

  /**
   * Defines all allowed input types.
   */
  const INPUT_TYPES = [
    'email', 'password', 'search', 'tel', 'text', 'url'
  ];


  /**
   * @inheritDoc
   */
  public function getEditorData(ElementInterface $element = null): array {
    return parent::getEditorData($element) + [
      'inputType'   => $this->getInputType(),
      'placeholder' => $this->getPlaceholder(),
    ];
  }

  /**
   * @inheritDoc
   */
  public function getValueRules(): array {
    $rules = parent::getValueRules();

    if ($this->inputType == 'url') {
      $rules[] = ['url'];
    } elseif ($this->inputType == 'email') {
      $rules[] = ['email'];
    }

    return $rules;
  }

  /**
   * @inheritDoc
   */
  public function rules(): array {
    return array_merge(
      parent::rules(),
      [
        ['placeholder', 'string'],
        ['inputType', 'required'],
        ['inputType', 'in', 'range' => self::INPUT_TYPES],
      ]
    );
  }


  // Private methods
  // ---------------

  /**
   * @return string
   */
  private function getInputType(): string {
    return in_array($this->inputType, self::INPUT_TYPES)
      ? $this->inputType
      : 'text';
  }

  /**
   * @return string
   */
  private function getPlaceholder(): string {
    $placeholder = trim($this->placeholder);

    return empty($placeholder)
      ? ''
      : Plugin::t($placeholder);
  }
}
