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
   * @var boolean
   */
  public $compact = false;

  /**
   * @var int
   */
  public $limit = 0;

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
      $config['member']['name'] = $config['name'];
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
   * @inheritDoc
   */
  public function getEditorData(ElementInterface $element = null) {
    if (is_null($this->member)) {
      return null;
    }

    return parent::getEditorData() + array(
      'collapsible' => !!$this->collapsible,
      'compact'     => !!$this->compact,
      'limit'       => is_int($this->limit) ? $this->limit : 0,
      'member'      => $this->member->getEditorData($element),
    );
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue($value) {
    if (!($value instanceof ArrayValue)) {
      return null;
    }

    return array_map(function($value) {
      return $this->member->getEditorValue($value);
    }, $value->toArray());
  }

  /**
   * @inheritDoc
   */
  public function getSearchKeywords($value) {
    if (!($value instanceof ArrayValue)) {
      return '';
    }

    return implode('', array_map(function($value) {
      return $this->member->getSearchKeywords($value);
    }, $value->toArray()));
  }

  /**
   * @inheritDoc
   */
  public function getSerializedValue($value) {
    if (!($value instanceof ArrayValue)) {
      return null;
    }

    return array_map(function($value) {
      return $this->member->getSerializedValue($value);
    }, $value->toArray());
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
