<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\SwatchColorField;

/**
 * Class SwatchColorFieldTest
 *
 * @method SwatchColorField createField(array $options)
 * @method SwatchColorField loadField(string $name, string $schema = null)
 */
class SwatchColorFieldTest extends AbstractEnumerationFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = SwatchColorField::class;

  /**
   * @inheritDoc
   */
  const FIELD_OPTIONS = [
    'type' => SwatchColorField::NAME,
  ];
}
