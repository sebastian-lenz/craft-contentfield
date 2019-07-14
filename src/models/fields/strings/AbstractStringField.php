<?php

namespace lenz\contentfield\models\fields\strings;

use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\models\values\StringValue;
use craft\base\ElementInterface;

/**
 * Class AbstractStringField
 */
abstract class AbstractStringField extends AbstractField
{
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
}
