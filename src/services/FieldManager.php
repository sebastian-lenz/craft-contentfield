<?php

namespace contentfield\services;

use contentfield\models\fields\AbstractField;
use contentfield\models\fields\ArrayField;
use contentfield\models\fields\InstanceField;
use contentfield\models\fields\ReferenceField;
use contentfield\models\fields\StringField;
use contentfield\models\widgets\AbstractWidget;
use contentfield\models\widgets\ArrayWidget;
use contentfield\models\widgets\InputWidget;
use contentfield\models\widgets\InstanceWidget;
use contentfield\models\widgets\RedactorWidget;
use contentfield\models\widgets\ReferenceWidget;

/**
 * Class FieldManager
 */
class FieldManager
{
  /**
   * A map of all known field types.
   * @var array
   */
  static $FIELD_TYPES = array(
    ArrayField::NAME     => ArrayField::class,
    InstanceField::NAME  => InstanceField::class,
    ReferenceField::NAME => ReferenceField::class,
    StringField::NAME    => StringField::class,
  );

  /**
   * A map of all known widget types.
   * @var array
   */
  static $WIDGET_TYPES = array(
    ArrayWidget::NAME     => ArrayWidget::class,
    InputWidget::NAME     => InputWidget::class,
    InstanceWidget::NAME  => InstanceWidget::class,
    RedactorWidget::NAME  => RedactorWidget::class,
    ReferenceWidget::NAME => ReferenceWidget::class,
  );


  /**
   * Creates a new field instance from the given configuration.
   *
   * @param array $config
   * @return AbstractField
   * @throws \Exception
   */
  public function createField($config) {
    $type = strtolower($config['type']);

    // We don't know the field type, let the widgets try to expand
    // the given configuration
    if (!array_key_exists($type, self::$FIELD_TYPES)) {
      foreach (self::$WIDGET_TYPES as $widgetClass) {
        $widgetClass::expandFieldConfig($config);
      }
    }

    $type = strtolower($config['type']);
    if (!array_key_exists($type, self::$FIELD_TYPES)) {
      throw new \Exception('Invalid field type "' . $type . '".');
    }

    $fieldClass = self::$FIELD_TYPES[$type];
    return new $fieldClass($config);
  }

  /**
   * @param array $config
   * @return AbstractWidget
   * @throws \Exception
   */
  public function createWidget(&$config) {
    $type = strtolower($config['widget']);
    if (!array_key_exists($type, self::$WIDGET_TYPES)) {
      throw new \Exception('Invalid widget type "' . $type . '".');
    }

    $widgetClass = self::$WIDGET_TYPES[$type];
    return new $widgetClass($config);
  }
}
