<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use Exception;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\Plugin;
use yii\base\Model;

/**
 * Class AbstractField
 *
 * Base class of all field types.
 */
abstract class AbstractField extends Model
{
  /**
   * The group name this field belongs to.
   * @var array|string
   */
  public $group;

  /**
   * The instructions displayed to the user.
   * @var string|null
   */
  public $instructions = null;

  /**
   * The human readable label of this field.
   * @var string
   */
  public $label;

  /**
   * The internal name of this field.
   * @var string
   */
  public $name;

  /**
   * The css styles applied to this field, grouped by breakpoint.
   * @var array
   */
  public $style;

  /**
   * The type of this field.
   * @var string
   */
  public $type;

  /**
   * The validation rules applied to the values of this field.
   * @var array|string
   */
  public $valueRules = [];

  /**
   * The width of this field in the control panel.
   *
   * This is a shorthand for:
   * ```
   * style:
   *   medium:
   *     width: <value>
   * ```
   *
   * @var string
   */
  public $width;

  /**
   * @var string
   */
  private $_clientValidationId;

  /**
   * The internal name of this field.
   */
  const NAME = '@invalid';

  /**
   * The breakpoint unbound styles will be assigned to.
   */
  const DEFAULT_BREAKPOINT = 'medium';

  /**
   * List of available responsive breakpoints.
   */
  const STYLE_BREAKPOINTS = [
    'small',
    'medium',
    'large',
  ];

  /**
   * List of style attributes allowed on fields.
   */
  const FIELD_STYLE_ATTRIBUTES = [
    'alignSelf',
    'flex',
    'flexBasis',
    'flexGrow',
    'flexShrink',
    'justifySelf',
    'width'
  ];

  /**
   * List of attributes allowed on groups.
   */
  const GROUP_ATTRIBUTES = [
    'label'
  ];

  /**
   * List of all group attributes that should be localized.
   */
  const GROUP_LOCALIZED_ATTRIBUTES = [
    'label'
  ];

  /**
   * List of style attributes allowed on groups.
   */
  const GROUP_STYLE_ATTRIBUTES = [
    'alignSelf',
    'gridArea',
    'gridColumn',
    'gridColumnEnd',
    'gridColumnStart',
    'gridRow',
    'gridRowEnd',
    'gridRowStart',
    'justifySelf',
    'placeSelf',
  ];


  /**
   * Field constructor.
   *
   * @param AbstractSchema|null $schema
   * @param array $config
   * @throws Exception
   */
  public function __construct(AbstractSchema $schema = null, array $config = []) {
    if (!isset($config['name'])) {
      throw new Exception('All fields must have a name.');
    }

    if (!isset($config['label'])) {
      $config['label'] = $this->generateAttributeLabel($config['name']);
    }

    if (isset($config['rules'])) {
      $config['valueRules'] = $config['rules'];
      unset($config['rules']);
    }

    parent::__construct($config);
  }

  /**
   * Return a list of all schemas this field and all of its children depend on.
   *
   * @return null|AbstractSchema[]
   */
  public function getDependedSchemas() {
    return null;
  }

  /**
   * Return the data of this field as required by the js editor.
   *
   * @param ElementInterface|null $element
   * @return array
   */
  public function getEditorData(ElementInterface $element = null) {
    return [
      'group'        => $this->getEditorGroupStyle(),
      'instructions' => Plugin::t($this->instructions),
      'isRequired'   => $this->isRequired(),
      'label'        => Plugin::t($this->label),
      'name'         => $this->name,
      'validatorId'  => $this->_clientValidationId,
      'style'        => $this->getEditorFieldStyle(),
      'type'         => strtolower($this->type),
    ];
  }

  /**
   * @param mixed $value
   * @return string
   */
  public function getSearchKeywords($value) {
    return '';
  }

  /**
   * Returns the data of this value for storing in the database. By default,
   * this is the same as `$this->getEditorData()`.
   *
   * @param mixed $value
   * @return mixed
   */
  public function getSerializedValue($value) {
    return $this->getEditorValue($value);
  }

  /**
   * @return array
   */
  public function getValueRules() {
    if (is_string($this->valueRules)) {
      $rules = [$this->valueRules];
    } else {
      $rules = is_array($this->valueRules)
        ? $this->valueRules
        : [];
    }

    $result = [];
    foreach ($rules as $key => $rule) {
      if (is_numeric($key)) {
        if (is_array($rule) && array_key_exists('type', $rule)) {
          $validator = (string)$rule['type'];
          unset($rule['type']);
          $options   = $rule;
        } else if (is_string($rule)) {
          $validator = (string)$rule;
          $options   = [];
        } else {
          continue;
        }
      } else {
        $validator = $key;
        $options   = is_array($rule) ? $rule : [];
      }

      $result[] = [$validator] + $options;
    }

    return $result;
  }

  /**
   * @return bool
   */
  public function isRequired() {
    foreach ($this->getValueRules() as $rule) {
      if ($rule[0] == 'required') {
        return true;
      }
    }

    return false;
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      ['name', 'validateName'],
    ];
  }

  /**
   * @param string $id
   */
  public function setClientValidationId($id) {
    $this->_clientValidationId = $id;
  }

  /**
   * Whether to validate the raw value or not.
   *
   * @return bool
   */
  public function useRawValueValidation() {
    return false;
  }

  /**
   * @param string $attribute
   */
  public function validateName($attribute) {
    if (!isset($this->$attribute) || !is_string($this->$attribute) || empty($this->$attribute)) {
      $this->addError($attribute, 'Field name is required.');
    } elseif (substr($this->name, 0 , 2) === '___') {
      $this->addError($attribute, 'Field names cannot start with two underscores.');
    }
  }


  // Abstract methods
  // ----------------

  /**
   * Transforms the given raw data into a value instance.
   *
   * @param mixed $data
   * @param ValueInterface|null $parent
   * @return mixed
   * @throws Exception
   */
  abstract public function createValue($data, ValueInterface $parent = null);

  /**
   * Returns the data of this value as required by the cp editor.
   *
   * @param mixed $value
   * @return mixed
   */
  abstract public function getEditorValue($value);


  // Private methods
  // ---------------

  /**
   * @return array|null
   */
  private function getEditorFieldStyle() {
    $style = isset($this->style) && is_array($this->style)
      ? $this->style
      : [];

    if (isset($this->width) && !empty($this->width)) {
      $width = (string)$this->width;
      if (preg_match('/(\d+)\/(\d+)/', $this->width, $match)) {
        $width = round(intval($match[1]) / intval($match[2]) * 100, 6) . '%';
      }

      $style[self::DEFAULT_BREAKPOINT]['width'] = $width;
    }

    return self::createBreakpoints($style, self::FIELD_STYLE_ATTRIBUTES);
  }

  /**
   * @return array|null
   */
  private function getEditorGroupStyle() {
    $group = [];
    $style = [];
    if (!isset($this->group)) {
      return null;
    }

    // Allow groups to be defined by label only, e.g.
    // ```
    // group: My group
    // ```
    $attributes = $this->group;
    if (!is_array($attributes)) {
      $attributes = ['label' => (string)$attributes];
    }

    // If there is a style attribute, use it as the style basis
    if (array_key_exists('style', $attributes)) {
      if (is_array($attributes['style'])) {
        $style = $attributes['style'];
      }

      unset($attributes['style']);
    }

    // Sort the remaining attributes into group and style attributes
    foreach ($attributes as $name => $value) {
      if (in_array($name, self::GROUP_LOCALIZED_ATTRIBUTES)) {
        $value = Plugin::t($value);
      }

      if (in_array($name, self::GROUP_ATTRIBUTES)) {
        $group[$name] = (string)$value;
      } else {
        $style[$name] = $value;
      }
    }

    $group['style'] = self::createBreakpoints($style, self::GROUP_STYLE_ATTRIBUTES);
    return $group;
  }


  // Static methods
  // --------------

  /**
   * @param array|string $source
   * @param array $allowedAttributes
   * @param string|null $defaultAttribute
   * @return array|null
   */
  static public function createBreakpoints($source, array $allowedAttributes, $defaultAttribute = null) {
    if (is_string($source) && !is_null($defaultAttribute)) {
      $source = [
        $defaultAttribute => $source
      ];
    }

    if (!is_array($source)) {
      return null;
    }

    $breakpoints = [];
    foreach ($source as $key => $value) {
      if (in_array($key, self::STYLE_BREAKPOINTS)) {
        if (is_string($value) && !is_null($defaultAttribute)) {
          $value = [
            $defaultAttribute => $value
          ];
        }

        $value = array_filter(
          is_array($value) ? $value : [],
          function($key) use ($allowedAttributes) {
            return in_array($key, $allowedAttributes);
          },
          ARRAY_FILTER_USE_KEY
        );

        if (count($value)) {
          $breakpoints[$key] = array_key_exists($key, $breakpoints)
            ? array_merge($value, $breakpoints[$key])
            : $value;
        }
      } elseif (in_array($key, $allowedAttributes)) {
        $breakpoints[self::DEFAULT_BREAKPOINT][$key] = $value;
      }
    }

    $styles = [];
    foreach (self::STYLE_BREAKPOINTS as $breakpoint) {
      if (array_key_exists($breakpoint, $breakpoints)) {
        $styles = array_merge($styles, $breakpoints[$breakpoint]);
      }

      $breakpoints[$breakpoint] = $styles;
    }

    return count($styles) == 0
      ? null
      : $breakpoints;
  }

  /**
   * Allows this widget to manipulate the given field configuration.
   *
   * Will be only invoked if the field type is not set to a valid field type
   * and will be invoked on all widget types.
   *
   * @param array $config
   */
  static public function expandFieldConfig(&$config) {}
}
