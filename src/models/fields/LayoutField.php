<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use craft\helpers\ArrayHelper;
use Exception;
use lenz\contentfield\Config;
use lenz\contentfield\helpers\grids\GridInterface;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\schemas\StructureSchema;
use lenz\contentfield\models\values\LayoutValue;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\Plugin;
use lenz\contentfield\validators\ColumnsValueValidator;
use lenz\contentfield\validators\FieldValidator;
use Throwable;
use yii\helpers\Inflector;

/**
 * Class LayoutField
 *
 * A field that stores multiple layout columns.
 */
class LayoutField extends AbstractField
{
  /**
   * Defines the available breakpoints.
   *
   * @var string[]
   */
  public $breakpoints = [
    'xs' => 'Mobile',
    'md' => 'Tablet',
    'lg' => 'Desktop',
  ];

  /**
   * @var bool
   */
  public $canEdit = true;

  /**
   * @var int
   */
  public $columnsPerRow = 12;

  /**
   * @var string|null
   */
  public $defaultPreset = null;

  /**
   * @var int
   */
  public $maxColumns = 12;

  /**
   * @var int
   */
  public $maxColumnWidth = 12;

  /**
   * @var int
   */
  public $minColumns = 1;

  /**
   * @var int
   */
  public $minColumnWidth = 1;

  /**
   * A field defining the value of each column.
   *
   * @var AbstractField|null
   */
  public $member = null;

  /**
   * @var array
   */
  public $presets = [];

  /**
   * @var string
   */
  private $_columnTypeQualifier;

  /**
   * @inheritdoc
   */
  const NAME = 'layout';


  /**
   * LayoutField constructor.
   *
   * @param AbstractSchema|null $schema
   * @param array $config
   * @throws Exception
   */
  public function __construct(AbstractSchema $schema = null, array $config = []) {
    parent::__construct($schema, $this->normalizeConfig($schema, $config));

    $this->_columnTypeQualifier = 'layout:' . $this->name . '@' . $schema->qualifier;
    $this->presets = $this->normalizePresets($this->presets);
  }

  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent = null) {
    return new LayoutValue($data, $parent, $this);
  }

  /**
   * @return string
   */
  public function getColumnTypeQualifier(): string {
    return $this->_columnTypeQualifier;
  }

  /**
   * @inheritdoc
   */
  public function getDependedSchemas() {
    if (!($this->member instanceof AbstractField)) {
      return null;
    }

    $schemas = $this->member->getDependedSchemas();
    return array_merge(
      is_array($schemas) ? $schemas : [],
      [
        new StructureSchema([
          'qualifier' => $this->_columnTypeQualifier,
          'fields' => [$this->member]
        ])
      ]
    );
  }

  /**
   * @inheritDoc
   */
  public function getEditorData(ElementInterface $element = null) {
    if (is_null($this->member)) {
      return null;
    }

    $breakpoints = [];
    foreach ($this->breakpoints as $key => $label) {
      $breakpoints[] = [
        'index' => count($breakpoints),
        'key' => $key,
        'label' => $label,
      ];
    }

    return array_merge(parent::getEditorData(), [
      'breakpoints' => $breakpoints,
      'canEdit' => $this->canEdit,
      'columnsPerRow' => $this->columnsPerRow,
      'columnTypeQualifier' => $this->_columnTypeQualifier,
      'defaultPreset' => $this->defaultPreset,
      'presets' => array_values($this->presets),
      'constraints' => [
        'maxColumns' => $this->maxColumns,
        'maxColumnWidth' => $this->maxColumnWidth,
        'minColumns' => $this->minColumns,
        'minColumnWidth' => $this->minColumnWidth,
      ]
    ]);
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue($value) {
    return $value instanceof LayoutValue
      ? $value->getEditorValue()
      : null;
  }

  /**
   * @return GridInterface
   */
  public function getGrid(): GridInterface {
    static $grid;
    if (isset($grid)) {
      return $grid;
    }

    $gridClass = Config::getInstance()->layoutGridClass;
    return $grid = new $gridClass();
  }

  /**
   * @inheritDoc
   */
  public function getSearchKeywords($value) {
    $member = $this->member;
    if (!($value instanceof LayoutValue) || is_null($member)) {
      return '';
    }

    return implode('', array_map(function($value) use ($member) {
      return $member->getSearchKeywords($value);
    }, $value->getValues()));
  }

  /**
   * @inheritDoc
   */
  public function getSerializedValue($value) {
    return $value instanceof LayoutValue
      ? $value->getSerializedValue()
      : null;
  }

  /**
   * @return array
   */
  public function getValueRules() {
    return array_merge(parent::getValueRules(), [
      [ColumnsValueValidator::class]
    ]);
  }

  /**
   * @param array $value
   * @return array
   */
  public function normalizeBreakpointMaps(array $value): array {
    foreach ([
     'offset' => 0,
     'order' => 0,
     'width' => $this->columnsPerRow,
   ] as $attribute => $defaultValue) {
      $value[$attribute] = self::toBreakpointMap(
        array_key_exists($attribute, $value) ? $value[$attribute] : [],
        $this->breakpoints,
        $defaultValue
      );
    }

    return $value;
  }

  /**
   * @inheritDoc
   */
  public function rules() {
    return array_merge(parent::rules(), [
      [['breakpoints', 'canEdit', 'columnsPerRow', 'maxColumns', 'maxColumnWidth',
        'minColumns', 'minColumnWidth', 'member'], 'required'],
      [['columnsPerRow', 'maxColumns', 'maxColumnWidth', 'minColumns',
        'minColumnWidth'], 'integer'],
      ['breakpoints', 'validateBreakpoints'],
      ['canEdit', 'boolean'],
      ['defaultPreset', 'string'],
      ['member', FieldValidator::class],
      ['presets', 'validatePresets'],
    ]);
  }

  /**
   * @param string $attribute
   * @noinspection PhpUnused (Used as validator)
   */
  public function validateBreakpoints(string $attribute) {
    $value = $this->$attribute;
    if (!is_array($value)) {
      $this->addError($attribute, 'Must be an array.');
    } elseif (count($value) < 1) {
      $this->addError($attribute, 'Must define at least one breakpoint.');
    } else {
      foreach ($value as $name => $label) {
        if (!is_string($label)) {
          $this->addError($attribute, "The label of the breakpoint `$name` is invalid, only strings are allowed.");
        }
      }
    }
  }

  /**
   * @param string $attribute
   * @noinspection PhpUnused (Used as validator)
   */
  public function validatePresets(string $attribute) {
    $this->normalizePresets($this->$attribute, $attribute);
  }


  // Private methods
  // ---------------

  /**
   * @param AbstractSchema|null $schema
   * @param array $config
   * @return array
   * @throws Exception
   */
  private function normalizeConfig(?AbstractSchema $schema, array $config): array {
    if (array_key_exists('schemas', $config)) {
      $config = $this->normalizeSchemasConfig($config);
    }

    if (array_key_exists('member', $config)) {
      $config['member'] = $this->normalizeMember($schema, $config['member']);
    }

    return $config;
  }

  /**
   * @param AbstractSchema|null $schema
   * @param mixed $member
   * @return AbstractField
   * @throws Exception
   */
  private function normalizeMember(?AbstractSchema $schema, $member): AbstractField {
    if (!is_array($member)) {
      $member = ['type' => $member];
    }

    $member['name'] = 'value';
    $member = Plugin::getInstance()
      ->fields
      ->createField($schema, $member);

    if ($member instanceof LayoutField) {
      throw new Exception('Columns fields cannot be nested.');
    }

    return $member;
  }

  /**
   * @param string|int $key
   * @param mixed $preset
   * @return array|string
   */
  private function normalizePreset($key, $preset) {
    if (!is_array($preset)) {
      return "The layout preset `$key` must be an array.";
    }

    if (!array_key_exists('columns', $preset)) {
      $preset = ['columns' => $preset];
    } else if (!is_array($preset['columns'])) {
      return "The attribute `columns` of the layout preset `$key` must be an array.";
    }

    if (!array_key_exists('key', $preset)) {
      $preset['key'] = $key;
    } else {
      $key = $preset['key'];
    }

    if (!array_key_exists('label', $preset)) {
      $preset['label'] = Inflector::camel2words($key, true);
    }

    return [
      'key' => is_numeric($key) ? intval($key) : (string)$key,
      'label' => (string)$preset['label'],
      'columns' => $this->normalizePresetColumns($preset['columns']),
    ];
  }

  /**
   * @param array $columns
   * @return array
   */
  private function normalizePresetColumns(array $columns): array {
    return array_map(function($column) {
      if (is_string($column)) {
        return $this->getGrid()->parse($this, $column);
      } elseif (is_array($column)) {
        try {
          $extraClasses = ArrayHelper::getValue($column, 'class');
          if (is_string($extraClasses)) {
            $extraClasses = preg_split('/\s+/', $extraClasses);
          } elseif (!is_array($extraClasses)) {
            $extraClasses = [$extraClasses];
          }
        } catch (Exception $e) {
          $extraClasses = [];
        }

        $column['class'] = $extraClasses;
        return $this->normalizeBreakpointMaps($column);
      } else {
        return [];
      }
    }, array_values($columns));
  }

  /**
   * @param mixed $value
   * @param string|null $emitErrors
   * @return array
   */
  private function normalizePresets($value, string $emitErrors = null): array {
    if (!is_array($value)) {
      if (!is_null($emitErrors)) {
        $this->addError($emitErrors, 'Must be an array.');
      }

      return [];
    }

    $presets = [];
    foreach ($value as $key => $preset) {
      $preset = $this->normalizePreset($key, $preset);
      if (is_array($preset)) {
        $presets[] = $preset;
      } elseif (!is_null($emitErrors)) {
        $this->addError($emitErrors, $preset);
      }
    }

    return ArrayHelper::index($presets, 'key');
  }

  /**
   * @param array $config
   * @return array
   */
  private function normalizeSchemasConfig(array $config): array {
    $instanceConfig = array_intersect_key($config, [
      'excludes' => true,
      'includes' => true,
      'name' => true,
      'schemas' => true,
    ]);

    $arrayConfig = array_intersect_key($config, [
      'collapsible' => true,
      'limit' => true,
      'name' => true,
      'previewMode' => true,
    ]);

    $baseConfig = array_intersect_key($config, [
      'breakpoints' => true,
      'canEdit' => true,
      'columnsPerRow' => true,
      'defaultPreset' => true,
      'group' => true,
      'label' => true,
      'maxColumns' => true,
      'maxColumnWidth' => true,
      'minColumns' => true,
      'minColumnWidth' => true,
      'name' => true,
      'presets' => true,
      'style' => true,
      'type' => true,
      'width' => true,
    ]);

    return array_merge($baseConfig, [
      'member' => array_merge($arrayConfig, [
        'type' => ArrayField::NAME,
        'member' => array_merge($instanceConfig, [
          'type' => InstanceField::NAME,
        ]),
      ]),
    ]);
  }

  /**
   * @param array $data
   * @param string $name
   * @param int $defaultValue
   * @return array
   */
  private function parseBreakpointMap(array $data, string $name, int $defaultValue): array {
    try {
      $source = ArrayHelper::getValue($data, $name);
    } catch (Throwable $error) {
      $source = [];
    }

    return self::toBreakpointMap($source, $this->breakpoints, $defaultValue);
  }


  // Static methods
  // --------------

  /**
   * @param mixed $source
   * @param array $breakpoints
   * @param int $defaultValue
   * @return array
   */
  static public function toBreakpointMap($source, array $breakpoints, int $defaultValue): array {
    $result = [];
    $lastValue = false;

    if (!is_array($source)) {
      $source = [];
    }

    foreach (array_keys($breakpoints) as $breakpoint) {
      $nextValue = $lastValue === false ? $defaultValue : $lastValue;
      if (array_key_exists($breakpoint, $source) && is_numeric($source[$breakpoint])) {
        $nextValue = intval($source[$breakpoint]);
      }

      if ($nextValue !== $lastValue) {
        $lastValue = $nextValue;
        $result[$breakpoint] = $nextValue;
      }
    }

    return $result;
  }
}
