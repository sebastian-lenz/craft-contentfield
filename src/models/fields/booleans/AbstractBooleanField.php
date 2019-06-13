<?php

namespace lenz\contentfield\models\fields\booleans;

use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\values\BooleanValue;
use lenz\contentfield\models\values\ValueInterface;
use craft\base\ElementInterface;

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
  public function createValue($data, ValueInterface $parent) {
    return new BooleanValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + array(
      'defaultValue' => !!$this->defaultValue
    );
  }
}
