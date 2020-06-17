<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\AbstractBooleanField;
use Throwable;

/**
 * Class AbstractBooleanField
 *
 * @method AbstractBooleanField createField(array $options)
 * @method AbstractBooleanField loadField(string $name, string $schema = null)
 */
abstract class AbstractBooleanFieldTest extends AbstractFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = AbstractBooleanField::class;


  /**
   * @throws Throwable
   */
  public function testEditorValue() {
    $field = $this->createField([
      'name' => 'testEditorValue',
    ]);

    $this->assertTrue($field->getEditorValue(true));
    $this->assertTrue($field->getEditorValue(1));
    $this->assertTrue($field->getEditorValue('1'));

    $this->assertFalse($field->getEditorValue(false));
    $this->assertFalse($field->getEditorValue(null));
  }

  /**
   * @throws Throwable
   */
  public function testValue() {
    $field = $this->createField([
      'name' => 'testValue',
    ]);

    $this->assertTrue($field->createValue(true));
    $this->assertTrue($field->createValue(1));
    $this->assertTrue($field->createValue('1'));

    $this->assertFalse($field->createValue(false));
    $this->assertFalse($field->createValue(null));
  }


  // Protected methods
  // -----------------

  /**
   * @inheritDoc
   */
  protected function validateEditorData(array $editorData) {
    parent::validateEditorData($editorData);

    $this->tester->assertArrayMembers([
      'defaultValue' => 'boolean',
    ], $editorData);
  }
}
