<?php

namespace contentfield\models\fields;

use contentfield\models\values\AbstractValue;
use contentfield\Plugin;
use craft\base\ElementInterface;
use craft\base\Model;

use contentfield\models\widgets\AbstractWidget;
use contentfield\models\schemas\AbstractSchema;

/**
 * Class AbstractField
 *
 * Base class of all field types.
 */
abstract class AbstractField extends Model
{
  /**
   * @var string
   */
  public $label;

  /**
   * @var string
   */
  public $name;

  /**
   * @var string
   */
  public $type;

  /**
   * @var AbstractWidget
   */
  public $widget;

  /**
   * Defines the default widget to use with this field.
   */
  const DEFAULT_WIDGET = AbstractWidget::NAME;

  /**
   * The internal name of this field.
   */
  const NAME = '@invalid';


  /**
   * Field constructor.
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

    if (!isset($config['widget'])) {
      $config['widget'] = static::NAME;
    }

    if (!($config['widget'] instanceof AbstractWidget)) {
      $config['widget'] = Plugin::getFieldManager()->createWidget($config);
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
      'label'  => $this->label,
      'name'   => $this->name,
      'type'   => $this->type,
      'widget' => $this->widget->getEditorData($element),
    );
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
}
