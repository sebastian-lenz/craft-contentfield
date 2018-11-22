<?php

namespace contentfield\services;

use contentfield\models\fields\AbstractField;
use contentfield\models\fields\ArrayField;
use contentfield\models\fields\ColorField;
use contentfield\models\fields\enumerations\SelectField;
use contentfield\models\fields\enumerations\SwatchColorField;
use contentfield\models\fields\InstanceField;
use contentfield\models\fields\LinkField;
use contentfield\models\fields\LocationField;
use contentfield\models\fields\ReferenceField;
use contentfield\models\fields\strings\RedactorField;
use contentfield\models\fields\strings\TextAreaField;
use contentfield\models\fields\strings\TextField;
use contentfield\models\fields\OEmbedField;

/**
 * Class FieldManager
 */
class FieldManager extends AbstractDefinitionService
{
  /**
   * @var array
   */
  protected $blueprints;

  /**
   * A map of all known field types.
   * @var array
   */
  static $FIELD_TYPES = array(
    ArrayField::NAME       => ArrayField::class,
    ColorField::NAME       => ColorField::class,
    InstanceField::NAME    => InstanceField::class,
    LinkField::NAME        => LinkField::class,
    LocationField::NAME    => LocationField::class,
    ReferenceField::NAME   => ReferenceField::class,
    RedactorField::NAME    => RedactorField::class,
    SelectField::NAME      => SelectField::class,
    SwatchColorField::NAME => SwatchColorField::class,
    TextAreaField::NAME    => TextAreaField::class,
    TextField::NAME        => TextField::class,
    OEmbedField::NAME     => OEmbedField::class,
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
    $config = $this->resolveDefinition($config);

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
   * @return string
   */
  protected function getDefinitionName() {
    return 'fields';
  }

  /**
   * @param string $type
   * @return boolean
   */
  protected function isNativeType($type) {
    return array_key_exists($type, self::$FIELD_TYPES);
  }
}
