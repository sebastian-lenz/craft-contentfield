<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\CheckboxField;

/**
 * Class CheckboxFieldTest
 *
 * @method CheckboxField createField(array $options)
 * @method CheckboxField loadField(string $name, string $schema = null)
 */
class CheckboxFieldTest extends AbstractBooleanFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = CheckboxField::class;

  /**
   * @inheritDoc
   */
  const FIELD_OPTIONS = [
    'type' => CheckboxField::NAME,
  ];
}
