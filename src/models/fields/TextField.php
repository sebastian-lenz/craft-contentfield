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
  public $inputType = 'text';

  /**
   * Specifies the maximum input length.
   *
   * @var int
   */
  public $maxLength;

  /**
   * A regular expression the value must match.
   *
   * @var string
   */
  public $pattern;

  /**
   * Placeholder text for the text input element. Translated using the default
   * translation method.
   *
   * @var string
   */
  public $placeholder = '';

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
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + [
      'inputType'   => $this->getInputType(),
      'maxLength'   => $this->maxLength,
      'pattern'     => $this->pattern,
      'placeholder' => $this->getPlaceholder(),
    ];
  }

  /**
   * @inheritDoc
   */
  public function getValueRules() {
    $stringRule = ['string'];
    if (isset($this->maxLength)) {
      $stringRule['max'] = $this->maxLength;
    }

    $rules = [$stringRule];
    if (isset($this->pattern)) {
      $rules[] = ['match', 'pattern' => $this->pattern];
    }

    if ($this->inputType == 'url') {
      $rules[] = ['url'];
    } elseif ($this->inputType == 'email') {
      $rules[] = ['email'];
    }

    return array_merge(
      parent::getValueRules(),
      $rules
    );
  }

  /**
   * @inheritDoc
   */
  public function rules() {
    return array_merge(
      parent::rules(),
      [
        [['pattern', 'placeholder'], 'string'],
        ['inputType', 'required'],
        ['inputType', 'in', 'range' => self::INPUT_TYPES],
        ['maxLength', 'integer'],
      ]
    );
  }


  // Private methods
  // ---------------

  /**
   * @return string
   */
  private function getInputType() {
    return in_array($this->inputType, self::INPUT_TYPES)
      ? $this->inputType
      : 'text';
  }

  /**
   * @return string
   */
  private function getPlaceholder() {
    $placeholder = trim((string)$this->placeholder);

    return empty($placeholder)
      ? ''
      : Plugin::t($placeholder);
  }
}
