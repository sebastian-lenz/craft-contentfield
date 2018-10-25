<?php

namespace contentfield\models\fields;

use contentfield\models\values\AbstractValue;
use craft\base\ElementInterface;
use craft\base\Model;

use contentfield\models\schemas\AbstractSchema;

/**
 * Class AbstractField
 *
 * Base class of all field types.
 */
abstract class AbstractField extends Model
{
  /**
   * The group name this field belongs to.
   * @var string
   */
  public $group;

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
   * The type of this field.
   * @var string
   */
  public $type;

  /**
   * The width of this field in the control panel.
   * @var string
   */
  public $width = '12/12';

  /**
   * The internal name of this field.
   */
  const NAME = '@invalid';


  /**
   * Field constructor.
   *
   * @param array $config
   * @throws \Exception
   */
  public function __construct(array $config = []) {
    if (!isset($config['name'])) {
      throw new \Exception('All fields must have a name.');
    }

    if (!isset($config['label'])) {
      $config['label'] = $this->generateAttributeLabel($config['name']);
    }

    parent::__construct($config);
  }

  /**
   * Transforms the given raw data into a value instance.
   *
   * @param mixed $data
   * @param AbstractValue $parent
   * @return AbstractValue
   * @throws \Exception
   */
  abstract function createValue($data, AbstractValue $parent);

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
    return array(
      'group'  => $this->group,
      'label'  => $this->label,
      'name'   => $this->name,
      'type'   => $this->type,
      'width'  => $this->width,
    );
  }

  /**
   * Return whether this fields stores html output.
   *
   * @return boolean
   */
  public function isHtmlField() {
    return false;
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return array(
      array('name', 'validateName'),
    );
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

  /**
   * Allows this widget to manipulate the given field configuration.
   *
   * Will be only invoked if the field type is not set to a valid field type
   * and will be invoked on all widget types.
   *
   * @param array $config
   */
  static function expandFieldConfig(&$config) {}
}
