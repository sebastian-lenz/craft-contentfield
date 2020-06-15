<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\AbstractNumberField;
use Throwable;

/**
 * Class AbstractNumberFieldTest
 *
 * @method AbstractNumberField createField(array $options)
 * @method AbstractNumberField loadField(string $name, string $schema = null)
 */
abstract class AbstractNumberFieldTest extends AbstractFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = AbstractNumberField::class;


  /**
   * @throws Throwable
   */
  public function testDefaultValue() {
    $defaultValue = rand();
    $field = $this->createField([
      'defaultValue' => $defaultValue,
      'name'         => 'testDefaultValue',
    ]);

    $this->assertEquals($defaultValue, $field->defaultValue);
    $this->assertEquals($defaultValue, $field->createValue(null));
    $this->assertEquals($defaultValue, $field->createValue(self::TEXT_DATA));
    $this->assertEquals($defaultValue, $field->createValue([true]));
  }

  /**
   * @throws Throwable
   */
  public function testEditorValue() {
    $field = $this->createField([
      'name' => 'testEditorValue',
    ]);

    $this->assertEquals(AbstractNumberField::DATA_TYPE_DOUBLE, $field->dataType);
    $this->assertFalse($field->optional);
    $this->assertNull($field->max);
    $this->assertNull($field->min);

    $this->assertEquals(1024.5, $field->getEditorValue(1024.5));
    $this->assertEquals(1024.5, $field->getEditorValue('1024.5'));
    $this->assertEquals(0, $field->getEditorValue(self::TEXT_DATA));
  }

  /**
   * @throws Throwable
   */
  public function testMinMax() {
    $field = $this->createField([
      'max'  => 10,
      'min'  => 0,
      'name' => 'testMinMax',
    ]);

    $this->assertEquals(0, $field->min);
    $this->assertEquals(10, $field->max);
    $this->assertEquals(0, $field->getEditorValue(-20));
    $this->assertEquals(10, $field->getEditorValue(20));

    $this->assertCount(1, array_filter(
      $field->getValueRules(),
      function($rule) {
        if (!is_array($rule) || $rule[0] != 'double') return false;
        $this->assertEquals(0, $rule['min']);
        $this->assertEquals(10, $rule['max']);
        return true;
      }
    ));
  }

  /**
   * @throws Throwable
   */
  public function testOptional() {
    $testValue = rand();
    $field = $this->createField([
      'optional' => true,
      'name'     => 'testOptional',
    ]);

    $this->assertTrue($field->optional);
    $this->assertEquals($testValue, $field->createValue($testValue));
    $this->assertNull($field->createValue(null));
    $this->assertNull($field->createValue(self::TEXT_DATA));
    $this->assertNull($field->createValue([true]));
  }

  /**
   * @throws Throwable
   */
  public function testValue() {
    $field = $this->createField([
      'dataType' => 'integer',
      'name'     => 'testValue',
    ]);

    $this->assertEquals(AbstractNumberField::DATA_TYPE_INTEGER, $field->dataType);
    $this->assertFalse($field->optional);
    $this->assertNull($field->max);
    $this->assertNull($field->min);

    $this->assertEquals(1024, $field->createValue(1024));
    $this->assertEquals(1024, $field->createValue('1024.5'));
    $this->assertEquals(0, $field->createValue(self::TEXT_DATA));
  }


  // Protected methods
  // -----------------

  /**
   * @inheritDoc
   */
  protected function validateEditorData(array $editorData) {
    parent::validateEditorData($editorData);

    $this->tester->assertArrayMembers([
      'dataType'     => 'string',
      'defaultValue' => ['numeric', 'null'],
      'max'          => ['numeric', 'null'],
      'min'          => ['numeric', 'null'],
      'optional'     => 'boolean',
    ], $editorData);
  }
}
