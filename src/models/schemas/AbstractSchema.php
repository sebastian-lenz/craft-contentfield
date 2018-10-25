<?php

namespace contentfield\models\schemas;

use craft\base\ElementInterface;
use craft\base\Model;

use contentfield\models\fields\AbstractField;
use contentfield\models\values\InstanceValue;
use contentfield\Plugin;

/**
 * Class AbstractSchema
 *
 * Base class of all schemas.
 */
abstract class AbstractSchema extends Model
{
  /**
   * A list of all fields attached to this schema.
   * @var AbstractField[]
   */
  public $fields = array();

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
   * A handlebars template used to display instances of this schema in the editor.
   * @var string
   */
  public $preview;

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
   * AbstractSchema constructor.
   *
   * @param array $config
   * @throws \Exception
   */
  public function __construct(array $config = []) {
    if (!isset($config['qualifier'])) {
      throw new \Exception('All schemas must have a qualifier.');
    }

    if (isset($config['fields'])) {
      $fieldManager = Plugin::getFieldManager();
      foreach ($config['fields'] as $key => $field) {
        // If the field is no an array try to load blueprint or use it
        // as the field type
        if (is_string($field)) {
          if ($fieldManager->hasBlueprint($field)) {
            $field = $fieldManager->getBlueprint($field);
          } else {
            $field = array('type' => $field);
          }
        }

        // If the field list is associative, use the keys as the field names
        if (is_string($key)) {
          if (isset($field['name'])) {
            \Craft::warning(array('The field `$1` has multiple names.', $key), 'craft-contentfield');
          }

          $field['name'] = $key;
        }

        if (!is_array($field) || !isset($field['type']) || !isset($field['name'])) {
          throw new \Exception('Invalid schema');
        }

        $instance = $fieldManager->createField($field);
        if (isset($this->fields[$instance->name])) {
          throw new \Exception('The field "' . $instance->name . '" is already set on schema "' . $config['qualifier'] . '".');
        }

        $this->fields[$instance->name] = $instance;
      }

      unset($config['fields']);
    }

    parent::__construct($config);
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
      'label'     => $this->getLabel(),
      'preview'   => $this->getPreview(),
      'qualifier' => $this->qualifier,
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
    \Craft::$app->getView()->registerTranslations(
      Plugin::$TRANSLATION_CATEGORY,
      array($this->label)
    );

    return $this->label;
  }

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
   * Renders this schema.
   *
   * @param InstanceValue $instance
   * @param array $variables
   * @return string
   */
  abstract function render(InstanceValue $instance, array $variables = []);

  /**
   * @inheritdoc
   */
  public function rules() {
    return array(
      array('fields',    'validateFields'),
      array('icon',      'string'),
      array('label',     'string'),
      array('preview',   'string'),
      array('qualifier', 'required'),
      array('qualifier', 'string'),
    );
  }

  /**
   * A validator that checks the fields of this schema.
   *
   * @param string $attribute
   */
  public function validateFields($attribute) {
    if (!isset($this->$attribute)) {
      return $this->addError($attribute, 'Fields not set.');
    } elseif (!is_array($this->$attribute)) {
      return $this->addError($attribute, 'Fields must be an array.');
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
}
