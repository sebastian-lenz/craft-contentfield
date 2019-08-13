<?php

namespace lenz\contentfield\models\fields;

use Exception;
use lenz\contentfield\models\schemas\AbstractSchema;
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
   * Whether the elements in this array can be expanded / collapsed
   * or not. When set to false the edit form will be shown directly.
   *
   * @var boolean
   */
  public $collapsible = true;

  /**
   * The preview mode to use when elements are collapsed. Affects only
   * arrays consisting of instances. Defaults to `root`.
   *
   * Allowed values are:
   * - `always`: Always shows the extended preview as defined by the
   *   `preview` instance property.
   * - `never`: Never shows a preview, always uses `previewLabel`.
   * - `root`: Only show the extended preview if the array is at the
   *   first display level.
   *
   * @var string
   */
  public $previewMode = 'root';

  /**
   * The maximum number of elements allowed in this array.
   *
   * @var int|mixed
   */
  public $limit = 0;

  /**
   * A field defining each member within the array. Can be any field
   * except another array field.
   *
   * @var AbstractField|null
   */
  public $member = null;

  /**
   * @inheritdoc
   */
  const NAME = 'array';


  /**
   * ArrayField constructor.
   *
   * @param AbstractSchema|null $schema
   * @param array $config
   * @throws Exception
   */
  public function __construct(AbstractSchema $schema = null, array $config = []) {
    if (array_key_exists('member', $config)) {
      $member = $config['member'];
      if (!is_array($member)) {
        $member = ['type' => $member];
      }

      if (!array_key_exists('name', $member)) {
        $member['name'] = $config['name'];
      }

      $member = Plugin::getInstance()
        ->fields
        ->createField($schema, $member);

      if ($member instanceof ArrayField) {
        throw new Exception('Array fields cannot be nested.');
      }

      $config['member'] = $member;
    }

    parent::__construct($schema, $config);
  }

  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent = null) {
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
      'limit'       => is_int($this->limit) ? $this->limit : 0,
      'member'      => $this->member->getEditorData($element),
      'previewMode' => $this->previewMode,
    );
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue($value) {
    $member = $this->member;
    if (!($value instanceof ArrayValue) || is_null($member)) {
      return null;
    }

    return array_map(function($value) use ($member) {
      return $member->getEditorValue($value);
    }, $value->getValues());
  }

  /**
   * @inheritDoc
   */
  public function getSearchKeywords($value) {
    if (
      !($value instanceof ArrayValue) ||
      is_null($this->member)
    ) {
      return '';
    }

    return implode('', array_map(function($value) {
      return $this->member->getSearchKeywords($value);
    }, $value->getValues()));
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
    }, $value->getValues());
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
