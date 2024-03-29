<?php

namespace lenz\contentfield\models\fields;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\helpers\Html;
use lenz\contentfield\helpers\redactor\FieldProxy;
use lenz\contentfield\helpers\StringHelper;
use lenz\contentfield\models\values\RedactorValue;
use lenz\contentfield\models\values\ValueInterface;
use Throwable;

/**
 * Class RedactorField
 *
 * Displays a redactor input field.
 */
class RedactorField extends AbstractField
{
  /**
   * @var string|null
   */
  public ?string $purifierConfig = null;

  /**
   * @var string|null
   */
  public ?string $redactorConfig = 'Standard.json';

  /**
   * @var bool
   */
  public bool $searchable = true;

  /**
   * @var bool
   */
  public bool $translatable = true;

  /**
   * @var FieldProxy|null
   */
  private ?FieldProxy $_proxy;

  /**
   * The internal name of this widget.
   */
  const NAME = 'redactor';


  /**
   * @inheritdoc
   */
  public function createValue(mixed $data, ValueInterface $parent = null): RedactorValue {
    return new RedactorValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null): array {
    return parent::getEditorData($element) + [
      'redactor'     => $this->getRedactorSettings($element),
      'translatable' => !!$this->translatable,
    ];
  }

  /**
   * @inheritdoc
   */
  public function getEditorValue(mixed $value): ?string {
    if (!($value instanceof RedactorValue)) {
      return null;
    }

    $value = $value->getRawContent();
    if ($value !== '') {
      $value = str_replace('<!--pagebreak-->', Html::tag('hr', '', [
        'class' => 'redactor_pagebreak',
        'style' => ['display' => 'none'],
        'unselectable' => 'on',
        'contenteditable' => 'false',
      ]), $value);
    }
    
    return $value;
  }

  /**
   * @param ElementInterface|null $element
   * @return array
   */
  public function getRedactorSettings(ElementInterface $element = null): array {
    try {
      return $this->getRedactorFieldProxy()->getFieldSettings(
        $element instanceof Element ? $element : null
      );
    } catch (Throwable) {
      // Ignore
    }

    return [];
  }

  /**
   * @inheritDoc
   */
  public function getSearchKeywords(mixed $value): string {
    if (!$this->searchable || !($value instanceof RedactorValue)) {
      return '';
    }

    return (string)$value;
  }

  /**
   * @inheritdoc
   */
  public function getSerializedValue(mixed $value, ElementInterface $element = null): ?string {
    if (!($value instanceof RedactorValue)) {
      return null;
    }

    try {
      $field = $this->getRedactorFieldProxy();
      return StringHelper::sanitizeString(
        $field->serializeValue($value->getRawContent(), $value->getElement())
      );
    } catch (Throwable $error) {
      Craft::error($error->getMessage());
    }

    return StringHelper::sanitizeString(
      $value->getRawContent()
    );
  }

  /**
   * @inheritDoc
   */
  public function rules(): array {
    return array_merge(
      parent::rules(),
      [
        [['redactorConfig', 'searchable', 'translatable'], 'required'],
        [['purifierConfig', 'redactorConfig'], 'string'],
        [['searchable', 'translatable'], 'boolean'],
      ]
    );
  }


  // Private methods
  // ---------------

  /**
   * @return FieldProxy|null
   */
  private function getRedactorFieldProxy(): ?FieldProxy {
    if (!isset($this->_proxy)) {
      try {
        $this->_proxy = new FieldProxy([
          'purifierConfig' => $this->purifierConfig,
          'redactorConfig' => $this->redactorConfig,
          'showHtmlButtonForNonAdmins' => true,
        ]);
      } catch (Throwable) {
        $this->_proxy = null;
      }
    }

    return $this->_proxy;
  }
}
