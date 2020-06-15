<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\LocationField;
use lenz\contentfield\models\values\LocationValue;
use Throwable;

/**
 * Class LocationFieldTest
 *
 * @method LocationField createField(array $options)
 * @method LocationField loadField(string $name, string $schema = null)
 */
class LocationFieldTest extends AbstractFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = LocationField::class;

  /**
   * @inheritDoc
   */
  const FIELD_OPTIONS = [
    'type' => LocationField::NAME
  ];


  /**
   * @throws Throwable
   */
  public function testDefaultValue() {
    $defaultValue = $this->createLocationData();
    $field = $this->createField([
      'defaultValue' => $defaultValue,
      'name'         => 'testDefaultValue',
    ]);

    $editorData = $field->getEditorData();
    $this->assertEquals($defaultValue, $field->defaultValue);
    $this->assertEquals($defaultValue, $editorData['defaultValue']);
  }

  /**
   * @throws Throwable
   */
  public function testEditorValue() {
    $location = $this->createLocation();
    $field = $this->createField([
      'name' => 'testEditorValue',
    ]);

    $this->assertNull($field->getEditorValue(self::TEXT_DATA));

    $editorValue = $field->getEditorValue($location);
    $this->tester->assertArrayMembers([
      'latitude'  => 'float',
      'longitude' => 'float',
    ], $editorValue);
  }

  /**
   * @throws Throwable
   */
  public function testValue() {
    $field = $this->createField([
      'name' => 'testValue',
    ]);

    $this->assertInstanceOf(LocationValue::class, $field->createValue(true));
    $this->assertInstanceOf(LocationValue::class, $field->createValue(156));
    $this->assertInstanceOf(LocationValue::class, $field->createValue(self::TEXT_DATA));
    $this->assertInstanceOf(LocationValue::class, $field->createValue($this->createLocationData()));
  }


  // Protected methods
  // -----------------

  /**
   * @return LocationValue
   */
  protected function createLocation() {
    return new LocationValue($this->createLocationData());
  }

  /**
   * @param int $precision
   * @return array
   */
  protected function createLocationData($precision = 1000) {
    return [
      'latitude' => rand(-90 * $precision, 90 * $precision) / $precision,
      'longitude' => rand(-180 * $precision, 180 * $precision) / $precision,
    ];
  }

  /**
   * @inheritDoc
   */
  protected function validateEditorData(array $editorData) {
    parent::validateEditorData($editorData);

    $this->tester->assertArrayMembers([
      'defaultValue' => 'array',
    ], $editorData);
  }
}
