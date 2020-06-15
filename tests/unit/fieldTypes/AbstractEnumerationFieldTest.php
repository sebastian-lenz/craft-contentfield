<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use Exception;
use lenz\contentfield\models\enumerations\StaticEnumeration;
use lenz\contentfield\models\fields\AbstractEnumerationField;
use lenz\contentfield\models\values\EnumerationValue;
use lenz\contentfield\tests\unit\fieldTypes\helpers\CustomEnumeration;
use Throwable;

/**
 * Class AbstractEnumerationFieldTest
 *
 * @method AbstractEnumerationField createField(array $options)
 * @method AbstractEnumerationField loadField(string $name, string $schema = null)
 */
abstract class AbstractEnumerationFieldTest extends AbstractFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = AbstractEnumerationField::class;


  /**
   * @throws Throwable
   */
  public function testEditorValue() {
    $field = $this->createField([
      'name' => 'testEditorValue',
    ]);

    $this->assertIsString($field->getEditorValue(new EnumerationValue([true])));
    $this->assertIsString($field->getEditorValue(new EnumerationValue(null)));
    $this->assertIsString($field->getEditorValue(new EnumerationValue('a')));
    $this->assertIsInt($field->getEditorValue(new EnumerationValue(1)));
  }

  /**
   * @throws Throwable
   */
  public function testEnumeration() {
    $field = $this->createField([
      'name' => 'testEnumeration',
      'enumeration' => CustomEnumeration::class,
    ]);

    $this->assertInstanceOf(CustomEnumeration::class, $field->getEnumeration());

    $field = $this->createField([
      'name' => 'testEnumeration',
      'enumeration' => [
        'type' => CustomEnumeration::class,
        'info' => self::TEXT_DATA,
      ],
    ]);

    $enum = $field->getEnumeration();
    $this->assertInstanceOf(CustomEnumeration::class, $enum);
    $this->assertEquals(self::TEXT_DATA, $enum->config['info']);

    $this->expectException(Exception::class);
    $this->createField([
      'name' => 'testEnumeration',
      'enumeration' => \Craft::class,
    ]);
  }

  /**
   * @throws Throwable
   */
  public function testOptions() {
    foreach ([
      'left, center, left, right',
      ['left', 'center', 'left', 'right'],
    ] as $options) {
      $field = $this->createField([
        'name'    => 'testOptions',
        'options' => $options,
      ]);

      $enumeration = $field->getEnumeration();
      $this->assertInstanceOf(StaticEnumeration::class, $enumeration);
      $this->assertEquals([
        ['key' => 'center', 'label' => 'Center'],
        ['key' => 'left',   'label' => 'Left'],
        ['key' => 'right',  'label' => 'Right'],
      ], $enumeration->getOptions());
    }
  }

  /**
   * @throws Throwable
   */
  public function testOptionsMap() {
    $field = $this->createField([
      'name' => 'testOptions',
      'options' => [
        'a' => 'Option A',
        'b' => 'Option B',
        'c' => 'Option C',
      ]
    ]);

    $enumeration = $field->getEnumeration();
    $this->assertInstanceOf(StaticEnumeration::class, $enumeration);
    $this->assertEquals([
      ['key' => 'a', 'label' => 'Option A'],
      ['key' => 'b', 'label' => 'Option B'],
      ['key' => 'c', 'label' => 'Option C'],
    ], $enumeration->getOptions());
  }

  /**
   * @throws Throwable
   */
  public function testValue() {
    $field = $this->createField([
      'name' => 'testValue',
    ]);

    $this->assertInstanceOf(EnumerationValue::class, $field->createValue(true));
    $this->assertInstanceOf(EnumerationValue::class, $field->createValue(1));
    $this->assertInstanceOf(EnumerationValue::class, $field->createValue('1'));
    $this->assertInstanceOf(EnumerationValue::class, $field->createValue([1024]));
  }


  // Protected methods
  // -----------------

  /**
   * @inheritDoc
   */
  protected function validateEditorData(array $editorData) {
    parent::validateEditorData($editorData);

    $this->tester->assertArrayMembers([
      'defaultValue' => ['string', 'null', 'int'],
      'options'      => 'array',
    ], $editorData);
  }
}
