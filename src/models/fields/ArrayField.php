<?php

namespace sebastianlenz\contentfield\models\fields;

use sebastianlenz\contentfield\models\values\ValueInterface;
use sebastianlenz\contentfield\models\values\ArrayValue;
use sebastianlenz\contentfield\Plugin;
use craft\base\ElementInterface;

/**
 * Class ArrayField
 */
class ArrayField extends AbstractField
{
  /**
   * @var boolean
   */
  public $collapsible = true;

  /**
   * @var AbstractField
   */
  public $member;

  /**
   * @inheritdoc
   */
  const NAME = 'array';


  /**
   * ArrayField constructor.
   * @param array $config
   * @throws \Exception
   */
  public function __construct(array $config = []) {
    if (array_key_exists('member', $config)) {
      $config['member'] = Plugin::getInstance()
        ->fields
        ->createField($config['member']);
    }

    parent::__construct($config);
  }

  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent) {
    return new ArrayValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getDependedSchemas() {
    return $this->member instanceof AbstractField
      ? $this->member->getDependedSchemas()
      : null;
  }

  /**
   * @param ElementInterface|null $element
   * @return array|null
   */
  public function getEditorData(ElementInterface $element = null) {
    if (is_null($this->member)) {
      return null;
    }

    return parent::getEditorData() + array(
      'collapsible' => !!$this->collapsible,
      'member'      => $this->member->getEditorData($element),
    );
  }
}
