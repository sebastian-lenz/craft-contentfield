<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use lenz\contentfield\models\values\ValueInterface;

/**
 * Class AbstractBooleanField
 */
abstract class AbstractBooleanField extends AbstractField
{
  /**
   * @var boolean
   */
  public $defaultValue = false;


  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent = null) {
    return !!$data;
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + array(
      'defaultValue' => !!$this->defaultValue
    );
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue($value) {
    return !!$value;
  }

  /**
   * @inheritDoc
   */
  public function useRawValueValidation() {
    return true;
  }
}
