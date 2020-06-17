<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\AbstractNumberField;
use lenz\contentfield\models\fields\NumberField;

/**
 * Class NumberFieldTest
 *
 * @method NumberField createField(array $options)
 * @method NumberField loadField(string $name, string $schema = null)
 */
class NumberFieldTest extends AbstractNumberFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = NumberField::class;

  /**
   * @inheritDoc
   */
  const FIELD_DEFAULT_SCHEMA = 'unit/fieldTypes/number';

  /**
   * @inheritDoc
   */
  const FIELD_OPTIONS = [
    'type' => NumberField::NAME,
  ];


  /**
   * @inheritDoc
   */
  public function testAliases() {
    $this->assertEquals(
      AbstractNumberField::DATA_TYPE_INTEGER,
      $this->loadField('int')->dataType
    );

    $this->assertEquals(
      AbstractNumberField::DATA_TYPE_INTEGER,
      $this->loadField('integer')->dataType
    );

    $this->assertEquals(
      AbstractNumberField::DATA_TYPE_DOUBLE,
      $this->loadField('double')->dataType
    );

    $this->assertEquals(
      AbstractNumberField::DATA_TYPE_DOUBLE,
      $this->loadField('float')->dataType
    );
  }


  // Protected methods
  // -----------------

  /**
   * @inheritDoc
   */
  protected function validateEditorData(array $editorData) {
    parent::validateEditorData($editorData);

    $this->tester->assertArrayMembers([
      'placeholder' => 'string',
      'unit'        => ['string', 'null'],
    ], $editorData);
  }
}
