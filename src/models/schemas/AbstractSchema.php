<?php

namespace lenz\contentfield\models\schemas;

use Craft;
use craft\base\ElementInterface;
use Exception;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\Plugin;
use lenz\contentfield\validators\ValueValidator;
use yii\base\Model;

/**
 * Class AbstractSchema
 *
 * Base class of all schemas.
 */
abstract class AbstractSchema extends Model
{
  /**
   * Custom data attached to this schema.
   * @var array
   */
  public $constants = [];

  /**
   * A list of all fields attached to this schema.
   * @var AbstractField[]
   */
  public $fields = [];

  /**
   * Defines the css grid layout of this schema. Grid layout is used
   * to place the field groups within the schema form.
   *
   * This is a shorthand for:
   * ```
   * style:
   *   medium:
   *     grid: <value>
   * ```
   *
   * @var string|array
   */
  public $grid;

  /**
   * The name of the icon that represents this schema.
   * @var string
   */
  public $icon;

  /**
   * A human readable name of this schema.
   * @var string
   */
  public $label;

  /**
   * @var string
   */
  public $mimeType = 'text/html';

  /**
   * A handlebars template used to display instances of this schema in the editor.
   * @var string
   */
  public $preview;

  /**
   * Marks this schema as a root schema. Only used to tidy up the cp field settings.
   * @var bool
   */
  public $rootSchema = false;

  /**
   * The css styles applied to form of this instance, grouped by breakpoint.
   * @var array
   */
  public $style;

  /**
   * The internal name of this schema.
   * @var string
   */
  public $qualifier;

  /**
   * The default icon to use if no icon is specified.
   */
  const DEFAULT_ICON = 'material:check_box_outline_blank';

  /**
   * List of allowed style attributes.
   */
  const STYLE_ATTRIBUTES = [
    'alignContent',
    'alignItems',
    'grid',
    'gridAutoColumns',
    'gridAutoFlow',
    'gridAutoRows',
    'gridColumnGap',
    'gridGap',
    'gridRowGap',
    'gridTemplate',
    'gridTemplateAreas',
    'gridTemplateColumns',
    'gridTemplateRows',
    'justifyContent',
    'justifyItems',
    'placeContent',
    'placeItems',
  ];


  /**
   * AbstractSchema constructor.
   *
   * @param array $config
   * @throws Exception
   */
  public function __construct(array $config = []) {
    if (!isset($config['qualifier'])) {
      throw new Exception('All schemas must have a qualifier.');
    }

    if (isset($config['fields'])) {
      $fieldManager = Plugin::getInstance()->fields;

      foreach ($config['fields'] as $key => $field) {
        // If the field is no an array try to load blueprint or use it
        // as the field type
        if (is_string($field)) {
          $field = array('type' => $field);
        }

        // If the field list is associative, use the keys as the field names
        if (is_string($key)) {
          if (isset($field['name'])) {
            Craft::warning(array('The field `$1` has multiple names.', $key), 'craft-contentfield');
          }

          $field['name'] = $key;
        }

        if (!is_array($field) || !isset($field['type']) || !isset($field['name'])) {
          throw new Exception('Invalid schema');
        }

        $instance = $fieldManager->createField($this, $field);
        if (isset($this->fields[$instance->name])) {
          throw new Exception('The field "' . $instance->name . '" is already set on schema "' . $config['qualifier'] . '".');
        }

        $this->fields[$instance->name] = $instance;
      }

      unset($config['fields']);
    }

    parent::__construct($config);
  }

  /**
   * @param BeforeActionEvent $event
   * @param Content $content
   */
  abstract function applyPageTemplate(BeforeActionEvent $event, Content $content);

  /**
   * @param InstanceValue $instance
   * @param array $variables
   */
  public function display(InstanceValue $instance, array $variables = []) {
    echo $this->render($instance, $variables);
  }

  /**
   * @param string $name
   * @return mixed|null
   */
  public function getConstant(string $name) {
    return array_key_exists($name, $this->constants)
      ? $this->constants[$name]
      : null;
  }

  /**
   * Return a list of all schemas this schema depends on, e.g.
   * when another schema is used by a field.
   *
   * @return AbstractSchema[]
   */
  public function getDependedSchemas() {
    $result = array();

    foreach ($this->fields as $field) {
      $schemas = $field->getDependedSchemas();
      if (is_null($schemas)) {
        continue;
      }

      foreach ($schemas as $schema) {
        if (!in_array($schema, $result)) {
          $result[] = $schema;
        }
      }
    }

    return $result;
  }

  /**
   * Return the data of this schema as required by the js editor.
   *
   * @param ElementInterface|null $element
   * @return array
   */
  public function getEditorData(ElementInterface $element = null) {
    $fields = array();

    foreach ($this->fields as $name => $field) {
      if (!$field->hasErrors()) {
        $fields[$name] = $field->getEditorData($element);
      }
    }

    return array(
      'fields'    => $fields,
      'icon'      => $this->getIcon(),
      'label'     => Plugin::t($this->getLabel()),
      'preview'   => $this->getPreview(),
      'qualifier' => $this->qualifier,
      'style'     => $this->getEditorStyle(),
    );
  }

  /**
   * Return the name of the icon that represents this schema.
   *
   * @return string
   */
  public function getIcon() {
    return isset($this->icon) ? $this->icon : self::DEFAULT_ICON;
  }

  /**
   * Return the human readable name of this schema.
   *
   * @return string
   */
  public function getLabel() {
    return $this->label;
  }

  /**
   * @param string $name
   * @return AbstractSchema|null
   */
  abstract public function getLocalStructure($name);

  /**
   * Return the handlebars template used to preview instances of this
   * schema in the editor.
   *
   * @return string
   */
  public function getPreview() {
    return $this->preview;
  }

  /**
   * @return array
   */
  public function getValueRules() {
    $result = [];

    foreach ($this->fields as $name => $field) {
      foreach ($field->getValueRules() as $rule) {
        $validator = $rule[0];
        $attribute = is_subclass_of($validator, ValueValidator::class)
          ? $name
          : 'raw:' . $name;

        unset($rule[0]);
        $result[] = [$attribute, $validator] + $rule;
      }
    }

    return $result;
  }

  /**
   * @return string
   * @throws Exception
   */
  public function getClientValidationScript() {
    $model      = new InstanceValue([], $this);
    $validators = [];
    $view       = Craft::$app->getView();

    foreach ($model->getActiveValidators() as $validator) {
      foreach ($validator->attributes as $attribute) {
        if (substr($attribute, 0, 4) == 'raw:') {
          $attribute = substr($attribute, 4);
        }

        $js = $validator->clientValidateAttribute($model, $attribute, $view);
        if ($validator->enableClientValidation && $js != '') {
          if ($validator->whenClient !== null) {
            $js = "if (({$validator->whenClient})(attribute, value)) { $js }";
          }

          $validators[$attribute][] = $js;
        }
      }
    }

    $result = '';
    foreach ($validators as $name => $handlers) {
      $id = uniqid();
      $this->fields[$name]->setClientValidationId($id);
      $result .= 'contentField.registerValidator("' . $id . '", function(attribute, value, messages, deferred, $form) {' . implode('', $handlers) . '});';
    }

    return $result;
  }

  /**
   * @param string $name
   * @return bool
   */
  public function hasConstant(string $name) {
    return array_key_exists($name, $this->constants);
  }

  /**
   * @param string $name
   * @return bool
   */
  abstract public function hasLocalStructure($name);

  /**
   * @param string|string[] $qualifier
   * @return boolean
   */
  public function matchesQualifier($qualifier) {
    if (is_array($qualifier)) {
      foreach ($qualifier as $value) {
        if ($this->qualifier == $this->normalizeQualifier($value)) {
          return true;
        }
      }

      return false;
    } else {
      return $this->qualifier == $this->normalizeQualifier($qualifier);
    }
  }

  /**
   * @param string $qualifier
   * @return string
   */
  public function normalizeQualifier(string $qualifier) {
    return $qualifier;
  }

  /**
   * Renders this schema.
   *
   * @param InstanceValue $instance
   * @param array $variables
   * @param array $options
   * @return string
   */
  abstract function render(InstanceValue $instance, array $variables = [], array $options = []);

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      ['qualifier', 'required'],
      [['icon', 'grid', 'label', 'preview', 'qualifier'], 'string'],
      ['constants', 'validateArray'],
      ['fields', 'validateFields'],
    ];
  }

  /**
   * @param string $attribute
   */
  public function validateArray($attribute) {
    if (!is_array($this->$attribute)){
      $this->addError($attribute, '{attribute} must be an array.');
    }
  }

  /**
   * A validator that checks the fields of this schema.
   *
   * @param string $attribute
   */
  public function validateFields($attribute) {
    if (!is_array($this->$attribute)) {
      $this->addError($attribute, "$attribute must be an array.");
      return;
    }

    foreach ($this->$attribute as $name => $field) {
      if (!($field instanceof AbstractField)) {
        $this->addError($attribute, "Field $name: fields must be an instances of the Field class.");
      } elseif (!$field->validate()) {
        foreach ($field->getErrors() as $errorAttribute => $errors)
        foreach ($errors as $attribute => $error) {
          $this->addError($attribute, "Field '$name', property '$errorAttribute': $error");
        }
      }
    }
  }


  // Protected methods
  // -----------------

  /**
   * @return array|null
   */
  protected function getEditorStyle() {
    $style = isset($this->style) && is_array($this->style)
      ? $this->style
      : [];

    if (isset($this->grid) && !empty($this->grid)) {
      $style[AbstractField::DEFAULT_BREAKPOINT]['grid'] = $this->grid;
    }

    return AbstractField::createBreakpoints($style, self::STYLE_ATTRIBUTES);
  }
}
