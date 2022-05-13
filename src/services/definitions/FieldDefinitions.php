<?php

namespace lenz\contentfield\services\definitions;

use Exception;
use lenz\contentfield\exceptions\FieldConfigException;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\fields\ArrayField;
use lenz\contentfield\models\fields\CheckboxField;
use lenz\contentfield\models\fields\ColorField;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\fields\LayoutField;
use lenz\contentfield\models\fields\LightswitchField;
use lenz\contentfield\models\fields\LinkField;
use lenz\contentfield\models\fields\LocationField;
use lenz\contentfield\models\fields\NumberField;
use lenz\contentfield\models\fields\OEmbedField;
use lenz\contentfield\models\fields\RedactorField;
use lenz\contentfield\models\fields\ReferenceField;
use lenz\contentfield\models\fields\SelectField;
use lenz\contentfield\models\fields\SwatchColorField;
use lenz\contentfield\models\fields\TextAreaField;
use lenz\contentfield\models\fields\TextField;
use lenz\contentfield\models\schemas\AbstractSchema;

/**
 * Class FieldDefinitions
 */
class FieldDefinitions extends AbstractDefinitions
{
  /**
   * A map of all known field types.
   * @var array
   */
  static array $FIELD_TYPES = [
    ArrayField::NAME       => ArrayField::class,
    CheckboxField::NAME    => CheckboxField::class,
    ColorField::NAME       => ColorField::class,
    LayoutField::NAME      => LayoutField::class,
    InstanceField::NAME    => InstanceField::class,
    LightswitchField::NAME => LightswitchField::class,
    LinkField::NAME        => LinkField::class,
    LocationField::NAME    => LocationField::class,
    NumberField::NAME      => NumberField::class,
    ReferenceField::NAME   => ReferenceField::class,
    RedactorField::NAME    => RedactorField::class,
    SelectField::NAME      => SelectField::class,
    SwatchColorField::NAME => SwatchColorField::class,
    TextAreaField::NAME    => TextAreaField::class,
    TextField::NAME        => TextField::class,
    OEmbedField::NAME      => OEmbedField::class,
  ];


  /**
   * Creates a new field instance from the given configuration.
   *
   * @param AbstractSchema|null $schema
   * @param array $config
   * @return AbstractField
   * @throws FieldConfigException
   * @throws Exception
   */
  public function createField(AbstractSchema $schema = null, array $config = []): AbstractField {
    $type   = strtolower($config['type']);
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
      throw new FieldConfigException($config, 'Invalid field type "' . $type . '".');
    }

    $fieldClass = self::$FIELD_TYPES[$type];
    return new $fieldClass($schema, $config);
  }

  /**
   * @return string
   */
  protected function getDefinitionName(): string {
    return 'fields';
  }

  /**
   * @param string $type
   * @return boolean
   */
  protected function isNativeType(string $type): bool {
    return array_key_exists($type, self::$FIELD_TYPES);
  }
}
