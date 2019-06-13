<?php

namespace lenz\contentfield\services;

use Exception;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\fields\ArrayField;
use lenz\contentfield\models\fields\booleans\CheckboxField;
use lenz\contentfield\models\fields\booleans\LightswitchField;
use lenz\contentfield\models\fields\ColorField;
use lenz\contentfield\models\fields\enumerations\SelectField;
use lenz\contentfield\models\fields\enumerations\SwatchColorField;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\fields\LinkField;
use lenz\contentfield\models\fields\LocationField;
use lenz\contentfield\models\fields\RedactorField;
use lenz\contentfield\models\fields\ReferenceField;
use lenz\contentfield\models\fields\strings\TextAreaField;
use lenz\contentfield\models\fields\strings\TextField;
use lenz\contentfield\models\fields\OEmbedField;

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
    CheckboxField::NAME    => CheckboxField::class,
    ColorField::NAME       => ColorField::class,
    InstanceField::NAME    => InstanceField::class,
    LightswitchField::NAME => LightswitchField::class,
    LinkField::NAME        => LinkField::class,
    LocationField::NAME    => LocationField::class,
    ReferenceField::NAME   => ReferenceField::class,
    RedactorField::NAME    => RedactorField::class,
    SelectField::NAME      => SelectField::class,
    SwatchColorField::NAME => SwatchColorField::class,
    TextAreaField::NAME    => TextAreaField::class,
    TextField::NAME        => TextField::class,
    OEmbedField::NAME      => OEmbedField::class,
  );


  /**
   * Creates a new field instance from the given configuration.
   *
   * @param array $config
   * @return AbstractField
   * @throws Exception
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
      throw new Exception('Invalid field type "' . $type . '".');
    }

    $fieldClass = self::$FIELD_TYPES[$type];
    return new $fieldClass($config);
  }

  /**
   * @inheritDoc
   */
  protected function getCacheKey() {
    return 'CONTENTFIELD_DEFS:FIELDS';
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
