<?php

namespace contentfield\services;

use contentfield\models\fields\AbstractField;
use contentfield\models\fields\ArrayField;
use contentfield\models\fields\enumerations\SelectField;
use contentfield\models\fields\InstanceField;
use contentfield\models\fields\ReferenceField;
use contentfield\models\fields\strings\RedactorField;
use contentfield\models\fields\strings\TextAreaField;
use contentfield\models\fields\strings\TextField;

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
    RedactorField::NAME  => RedactorField::class,
    SelectField::NAME    => SelectField::class,
    TextAreaField::NAME  => TextAreaField::class,
    TextField::NAME      => TextField::class
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
      foreach (self::$FIELD_TYPES as $fieldClass) {
        $fieldClass::expandFieldConfig($config);
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
   * Return the blueprint field definition for the given name.
   *
   * @param string $name
   * @return array
   */
  public function getBlueprint($name) {
    return array();
  }

  /**
   * Test whether the blueprint with the given name exists.
   *
   * @param string $name
   * @return bool
   */
  public function hasBlueprint($name) {
    return false;
  }
}
