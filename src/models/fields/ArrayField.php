<?php

namespace lenz\contentfield\models\fields;

use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\models\values\ArrayValue;
use lenz\contentfield\Plugin;
use craft\base\ElementInterface;
use lenz\contentfield\validators\ArrayValueValidator;

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

  /**
   * @return array
   */
  public function getValueRules() {
    return array_merge(
      [[ArrayValueValidator::class]],
      parent::getValueRules()
    );
  }
}
