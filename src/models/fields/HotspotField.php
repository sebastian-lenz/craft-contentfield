<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\HotspotValue;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\validators\ArrayLengthValidator;

/**
 * Class HotspotField
 */
class HotspotField extends AbstractField
{
  /**
   * @inheritdoc
   */
  const NAME = 'hotspot';

  /**
   * @var string[]|null
   */
  public ?array $allowedShapes = null;

  /**
   * @var array
   */
  public array $assetQuery = [];

  /**
   * @var int|null
   */
  public ?int $maxShapes = null;

  /**
   * @var int|null
   */
  public ?int $minShapes = null;


  /**
   * @param AbstractSchema|null $schema
   * @param array $config
   * @throws \Exception
   */
  public function __construct(AbstractSchema $schema = null, array $config = []) {
    if (isset($config['allowedShapes']) && !is_array($config['allowedShapes'])) {
      $config['allowedShapes'] = array_filter(
        array_map('trim', explode(',', $config['allowedShapes']))
      );
    }

    if (isset($config['assetQuery']) && !is_array($config['assetQuery'])) {
      $config['assetQuery'] = [$config['assetQuery']];
    }

    parent::__construct($schema, $config);
  }

  /**
   * @inheritdoc
   */
  public function createValue(mixed $data, ValueInterface $parent = null): HotspotValue {
    return new HotspotValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null): array {
    return [
      ...parent::getEditorData($element),
      'allowedShapes' => $this->allowedShapes,
      'assetQuery' => $this->assetQuery,
      'maxShapes' => $this->maxShapes,
      'minShapes' => $this->minShapes,
    ];
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue(mixed $value): ?array {
    return $value instanceof HotspotValue
      ? $value->jsonSerialize()
      : null;
  }

  /**
   * @inheritDoc
   */
  public function getValueRules(): array {
    $rules = parent::getValueRules();

    if (!empty($this->maxShapes) || !empty($this->minShapes)) {
      $rules[] = [ArrayLengthValidator::class, 'max' => $this->maxShapes, 'min' => $this->minShapes];
    }

    return $rules;
  }

  /**
   * @inheritdoc
   */
  public function rules(): array {
    return [
      ...parent::rules(),
      [['maxShapes', 'minShapes'], 'integer'],
      ['allowedShapes', 'in', 'allowArray' => true, 'range' => ['point', 'rectangle']],
    ];
  }
}
