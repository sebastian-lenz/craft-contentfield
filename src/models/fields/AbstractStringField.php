<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use lenz\contentfield\helpers\StringHelper;
use lenz\contentfield\models\values\ValueInterface;

/**
 * Class AbstractStringField
 */
abstract class AbstractStringField extends AbstractField
{
  /**
   * Specifies the maximum string length.
   *
   * @var int
   */
  public int $maxLength;

  /**
   * Specifies the minimum string length.
   *
   * @var int
   */
  public int $minLength;

  /**
   * A regular expression the string must match.
   *
   * @var string
   */
  public string $pattern;

  /**
   * @var bool
   */
  public bool $searchable = true;

  /**
   * @var bool
   */
  public bool $translatable = true;


  /**
   * @inheritdoc
   */
  public function createValue(mixed $data, ValueInterface $parent = null): ?string {
    return is_string($data) ? $data : null;
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null): array {
    return parent::getEditorData($element) + [
      'maxLength'    => $this->maxLength,
      'minLength'    => $this->minLength,
      'translatable' => !!$this->translatable
    ];
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue(mixed $value): ?string {
    return is_string($value) ? $value : null;
  }

  /**
   * @param mixed $value
   * @return string
   */
  public function getSearchKeywords(mixed $value): string {
    return $this->searchable && is_string($value) ? $value : '';
  }

  /**
   * @param mixed $value
   * @return string|null
   */
  public function getSerializedValue(mixed $value): ?string {
    $result = $this->getEditorValue($value);
    if (is_string($result)) {
      $result = StringHelper::sanitizeString($result);
    }

    return $result;
  }

  /**
   * @inheritDoc
   */
  public function getValueRules(): array {
    $stringRule = ['string'];

    if (isset($this->maxLength)) {
      $stringRule['max'] = $this->maxLength;
    }

    if (isset($this->minLength)) {
      $stringRule['min'] = $this->minLength;
    }

    $rules = [$stringRule];
    if (isset($this->pattern)) {
      $rules[] = ['match', 'pattern' => $this->pattern];
    }

    return array_merge(
      parent::getValueRules(),
      $rules
    );
  }

  /**
   * @inheritDoc
   */
  public function rules(): array {
    return array_merge(
      parent::rules(),
      [
        [['maxLength', 'minLength'], 'integer'],
        ['pattern', 'string'],
      ]
    );
  }

  /**
   * @inheritDoc
   */
  public function useRawValueValidation(): bool {
    return true;
  }
}
