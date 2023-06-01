<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use Exception;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\ArrayValue;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\Plugin;
use lenz\contentfield\validators\ArrayValueValidator;
use lenz\contentfield\validators\FieldValidator;

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
  public bool $collapsible = true;

  /**
   * The maximum number of elements allowed in this array.
   *
   * @var int
   */
  public int $limit = 0;

  /**
   * A field defining each member within the array. Can be any field
   * except another array field.
   *
   * @var AbstractField|null
   */
  public ?AbstractField $member = null;

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
  public string $previewMode = 'root';

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

      $member['name'] = $config['name'];
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
  public function createValue(mixed $data, ValueInterface $parent = null): ArrayValue {
    return new ArrayValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getDependedSchemas(): ?array {
    return $this->member instanceof AbstractField
      ? $this->member->getDependedSchemas()
      : null;
  }

  /**
   * @inheritDoc
   */
  public function getEditorData(ElementInterface $element = null): ?array {
    if (is_null($this->member)) {
      return null;
    }

    return parent::getEditorData() + [
      'collapsible' => !!$this->collapsible,
      'limit'       => $this->limit,
      'member'      => $this->member->getEditorData($element),
      'previewMode' => $this->previewMode,
    ];
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue(mixed $value): ?array {
    $member = $this->member;
    if (!($value instanceof ArrayValue) || is_null($member)) {
      return null;
    }

    return array_values(
      array_map(function($value) use ($member) {
        return $member->getEditorValue($value);
      }, $value->getValues())
    );
  }

  /**
   * @inheritDoc
   */
  public function getSearchKeywords(mixed $value): string {
    $member = $this->member;
    if (!($value instanceof ArrayValue) || is_null($member)) {
      return '';
    }

    return implode('', array_map(function($value) use ($member) {
      return $member->getSearchKeywords($value);
    }, $value->getValues()));
  }

  /**
   * @inheritDoc
   */
  public function getSerializedValue(mixed $value, ElementInterface $element = null): ?array {
    $member = $this->member;
    if (!($value instanceof ArrayValue) || is_null($member)) {
      return null;
    }

    return array_values(
      array_map(function($value) use ($member, $element) {
        return $member->getSerializedValue($value, $element);
      }, $value->getValues())
    );
  }

  /**
   * @return array
   */
  public function getValueRules(): array {
    return array_merge(
      [[ArrayValueValidator::class]],
      parent::getValueRules()
    );
  }

  /**
   * @inheritDoc
   */
  public function rules(): array {
    return array_merge(parent::rules(), [
      [['collapsible', 'limit', 'member', 'previewMode'], 'required'],
      ['collapsible', 'boolean'],
      ['limit', 'integer'],
      ['member', FieldValidator::class],
      ['previewMode', 'in', 'range' => ['always', 'never', 'root']],
    ]);
  }
}
