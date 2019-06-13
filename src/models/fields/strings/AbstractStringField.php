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
  public $translatable = true;


  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent) {
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
