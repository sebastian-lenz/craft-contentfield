<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use Exception;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\ValueInterface;

/**
 * Class AbstractNumberField
 */
abstract class AbstractNumberField extends AbstractField
{
  /**
   * The data type to store. Can be `double` or `float`.
   *
   * @var string
   */
  public $dataType = self::DATA_TYPE_DOUBLE;

  /**
   * The default value of this field.
   *
   * @var int|float
   */
  public $defaultValue = 0;

  /**
   * The maximum allowed numeric value.
   *
   * @var int|float|null
   */
  public $max = null;

  /**
   * The minimum allowed numeric value.
   *
   * @var int|float|null
   */
  public $min = null;

  /**
   * @var bool
   */
  public $optional = false;

  /**
   * Defines the allowed `dataType` values.
   */
  const DATA_TYPE_DOUBLE = 'double';
  const DATA_TYPE_INTEGER = 'integer';

  /**
   * A list of names for the double type.
   */
  const DATA_TYPE_ALIASES = [
    'double'  => 'double',
    'float'   => 'double',
    'int'     => 'integer',
    'integer' => 'integer',
  ];


  /**
   * AbstractNumberField constructor.
   *
   * @param AbstractSchema|null $schema
   * @param array $config
   * @throws Exception
   */
  public function __construct(AbstractSchema $schema = null, array $config = []) {
    if (
      array_key_exists('dataType', $config) &&
      array_key_exists($config['dataType'], self::DATA_TYPE_ALIASES)
    ) {
      $config['dataType'] = self::DATA_TYPE_ALIASES[$config['dataType']];
    }

    parent::__construct($schema, $config);
  }

  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent = null) {
    return $this->getEditorValue($data);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + [
      'dataType'     => $this->dataType,
      'defaultValue' => $this->getEditorValue($this->defaultValue),
      'max'          => $this->max,
      'min'          => $this->min,
      'optional'     => $this->optional,
    ];
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue($value) {
    if (!is_numeric($value)) {
      if ($this->optional) {
        return null;
      } else {
        $value = $this->defaultValue;
      }
    } elseif ($this->dataType == self::DATA_TYPE_INTEGER) {
      $value = intval($value);
    } else {
      $value = floatval($value);
    }

    if (isset($this->min) && $value < $this->min) {
      $value = $this->min;
    }

    if (isset($this->max) && $value > $this->max) {
      $value = $this->max;
    }

    return $value;
  }

  /**
   * @return array
   */
  public function getValueRules() {
    $numberRule = [$this->dataType];

    if (is_numeric($this->max)) {
      $numberRule['max'] = $this->max;
    }

    if (is_numeric($this->min)) {
      $numberRule['min'] = $this->min;
    }

    return array_merge(
      parent::getValueRules(),
      [$numberRule]
    );
  }

  /**
   * @inheritDoc
   */
  public function rules() {
    return array_merge(
      parent::rules(),
      [
        [['dataType', 'defaultValue', 'optional'], 'required'],
        [['defaultValue', 'max', 'min'], 'number'],
        ['dataType', 'in', 'range' => [self::DATA_TYPE_DOUBLE, self::DATA_TYPE_INTEGER]],
        ['placeholder', 'string'],
        ['optional', 'boolean']
      ]
    );
  }

  /**
   * @inheritDoc
   */
  public function useRawValueValidation() {
    return true;
  }
}
