<?php

namespace contentfield\models\fields\strings;

use contentfield\models\fields\AbstractField;
use contentfield\models\values\AbstractValue;
use contentfield\models\values\StringValue;
use craft\base\ElementInterface;

/**
 * Class AbstractStringField
 */
abstract class AbstractStringField extends AbstractField
{
  /**
   * @var bool
   */
  public $translatable = false;


  /**
   * @inheritdoc
   */
  public function createValue($data, AbstractValue $parent) {
    return new StringValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + array(
      'translatable' => !!$this->translatable
    );
  }
}
