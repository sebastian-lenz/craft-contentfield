<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
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
  public $maxLength;

  /**
   * Specifies the minimum string length.
   *
   * @var int
   */
  public $minLength;

  /**
   * A regular expression the string must match.
   *
   * @var string
   */
  public $pattern;

  /**
   * @var bool
   */
  public $searchable = true;

  /**
   * @var bool
   */
  public $translatable = true;


  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent = null) {
    return is_string($data) ? $data : null;
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + array(
      'maxLength'    => $this->maxLength,
      'minLength'    => $this->minLength,
      'translatable' => !!$this->translatable
    );
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue($value) {
    return is_string($value) ? $value : null;
  }

  /**
   * @param mixed $value
   * @return string
   */
  public function getSearchKeywords($value) {
    return $this->searchable && is_string($value) ? (string)$value : '';
  }

  /**
   * @inheritDoc
   */
  public function getValueRules() {
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
  public function rules() {
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
  public function useRawValueValidation() {
    return true;
  }
}
