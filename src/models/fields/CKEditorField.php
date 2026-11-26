<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use Exception;
use lenz\contentfield\helpers\ckeditor\FieldProxy;
use lenz\contentfield\helpers\StringHelper;
use lenz\contentfield\models\values\CKEditorValue;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\Plugin;
use lenz\contentfield\services\definitions\CKEditorConfigDefinitions;

/**
 * Class CKEditorField
 *
 * Displays a CKEditor field.
 */
class CKEditorField extends AbstractField
{
  /**
   * The CKEditor config to use. Either the name of a config stored
   * in `config/content/cke` or an inline config array.
   *
   * @var string|array|null
   */
  public string|array|null $ckeConfig = null;

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
      'translatable' => !!$this->translatable,
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
        [['editorClass'], 'string'],
        [['wordLimit'], 'number'],
        [['enableSourceEditingForNonAdmins', 'searchable', 'wordLimit', 'translatable'], 'boolean'],
      ]
    );
  }


  // Private methods
  // ---------------

  /**
   * @return array
   * @throws Exception
   */
  private function getCKEditorConfig(): array {
    if (is_array($this->ckeConfig)) {
      return CKEditorConfigDefinitions::withoutMeta($this->ckeConfig);
    }

    return empty($this->ckeConfig)
      ? []
      : Plugin::getInstance()->ckeConfigs->getConfig($this->ckeConfig);
  }

  /**
   * @return FieldProxy
   * @throws Exception
   */
  private function getFieldProxy(): FieldProxy {
    if (!isset($this->_proxy)) {
      $config = $this->getCKEditorConfig();
      $config['showWordCount'] = $this->showWordCount;
      $config['wordLimit'] = $this->wordLimit;

      if ($this->enableSourceEditingForNonAdmins) {
        $config['enableSourceEditingForNonAdmins'] = true;
      }

      $this->_proxy = new FieldProxy($config);
    }

    return $this->_proxy;
  }
}
