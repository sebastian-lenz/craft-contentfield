<?php

namespace sebastianlenz\contentfield\models\fields\strings;

use sebastianlenz\contentfield\models\fields\AbstractField;
use sebastianlenz\contentfield\models\values\AbstractValue;
use sebastianlenz\contentfield\models\values\StringValue;
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
