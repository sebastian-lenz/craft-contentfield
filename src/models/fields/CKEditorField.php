<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use lenz\contentfield\helpers\ckeditor\FieldProxy;
use lenz\contentfield\helpers\StringHelper;
use lenz\contentfield\models\values\CKEditorValue;
use lenz\contentfield\models\values\ValueInterface;

/**
 * Class CKEditorField
 *
 * Displays a CKEditor field.
 */
class CKEditorField extends AbstractField
{
  /**
   * @var string|null
   */
  public ?string $ckeConfig = null;

  /**
   * @var string|null
   */
  public ?string $editorClass = null;

  /**
   * @var bool
   */
  public bool $enableSourceEditingForNonAdmins = false;

  /**
   * @var bool
   */
  public bool $searchable = true;

  /**
   * @var bool
   */
  public bool $showWordCount = false;

  /**
   * @var bool
   */
  public bool $translatable = true;

  /**
   * @var int|null
   */
  public ?int $wordLimit = null;

  /**
   * @var FieldProxy|null
   */
  private ?FieldProxy $_proxy;

  /**
   * The internal name of this widget.
   */
  const NAME = 'ckeditor';


  /**
   * @inheritdoc
   */
  public function createValue(mixed $data, ValueInterface $parent = null): CKEditorValue {
    $element = $parent?->getElement();
    $data = is_string($data) ? $data : '';

    return new CKEditorValue($data, $element?->siteId, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null): array {
    return parent::getEditorData($element) + [
      'configId' => $this->getFieldProxy()->registerJs($element),
      'editorClass' => $this->editorClass,
      'showWordCount' => !!$this->showWordCount,
    ];
  }

  /**
   * @inheritdoc
   */
  public function getEditorValue(mixed $value): ?string {
    if (!($value instanceof CKEditorValue)) {
      return null;
    }

    $proxy = $this->getFieldProxy();
    return $proxy->getEditorValue($value, $value->getElement());
  }

  /**
   * @inheritDoc
   */
  public function getSearchKeywords(mixed $value): string {
    if (!$this->searchable || !($value instanceof CKEditorValue)) {
      return '';
    }

    return (string)$value;
  }

  /**
   * @inheritdoc
   */
  public function getSerializedValue(mixed $value, ElementInterface $element = null): ?string {
    if (!($value instanceof CKEditorValue)) {
      return null;
    }

    $field = $this->getFieldProxy();
    $result = $field->serializeValue($value, $element);
    return $result ? StringHelper::sanitizeString($result) : null;
  }

  /**
   * @inheritDoc
   */
  public function rules(): array {
    return array_merge(
      parent::rules(),
      [
        [['ckeConfig', 'editorClass'], 'string'],
        [['wordLimit'], 'number'],
        [['enableSourceEditingForNonAdmins', 'searchable', 'wordLimit', 'translatable'], 'boolean'],
      ]
    );
  }


  // Private methods
  // ---------------

  /**
   * @return FieldProxy
   */
  private function getFieldProxy(): FieldProxy {
    if (!isset($this->_proxy)) {
      $this->_proxy = new FieldProxy([
        'ckeConfig' => $this->ckeConfig,
        'enableSourceEditingForNonAdmins' => $this->enableSourceEditingForNonAdmins,
        'showWordCount' => $this->showWordCount,
        'wordLimit' => $this->wordLimit,
      ]);
    }

    return $this->_proxy;
  }
}
