<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\LightswitchField;

/**
 * Class LightswitchFieldTest
 *
 * @method LightswitchField createField(array $options)
 * @method LightswitchField loadField(string $name, string $schema = null)
 */
class LightswitchFieldTest extends AbstractBooleanFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = LightswitchField::class;

  /**
   * @inheritDoc
   */
  const FIELD_OPTIONS = [
    'type' => LightswitchField::NAME,
  ];
}
