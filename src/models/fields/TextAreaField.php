<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use lenz\contentfield\Plugin;

/**
 * Class TextAreaField
 *
 * Displays a textarea input.
 */
class TextAreaField extends AbstractStringField
{
  /**
   * Whether to use a monospace font in the control panel
   * or not.
   *
   * @var bool
   */
  public bool $monospace = false;

  /**
   * Placeholder text for the textarea element. Translated using the default
   * translation method.
   *
   * @var string
   */
  public string $placeholder = '';

  /**
   * The number of initially visible text lines.
   *
   * @var int
   */
  public int $rows = 5;

  /**
   * The internal name of this widget.
   */
  const NAME = 'textarea';


  /**
   * @inheritDoc
   */
  public function getEditorData(ElementInterface $element = null): array {
    return parent::getEditorData($element) + [
      'monospace'   => $this->monospace,
      'placeholder' => $this->getPlaceholder(),
      'rows'        => $this->rows,
    ];
  }

  /**
   * @inheritDoc
   */
  public function rules(): array {
    return array_merge(
      parent::rules(),
      [
        [['monospace', 'rows'], 'required'],
        ['monospace', 'boolean'],
        ['placeholder', 'string'],
        ['rows', 'integer'],
      ]
    );
  }


  // Private methods
  // ---------------

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
