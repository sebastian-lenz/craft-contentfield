<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\ColorField;
use lenz\contentfield\models\values\ColorValue;
use Throwable;

/**
 * Class ColorFieldTest
 *
 * @method ColorField createField(array $options)
 * @method ColorField loadField(string $name, string $schema = null)
 */
class ColorFieldTest extends AbstractFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = ColorField::class;

  /**
   * @inheritDoc
   */
  const FIELD_OPTIONS = [
    'type' => ColorField::NAME
  ];


  /**
   * @throws Throwable
   */
  public function testEditorValue() {
    $color = $this->createColor();
    $field = $this->createField([
      'name' => 'testEditorValue',
    ]);

    $this->assertNull($field->getEditorValue(self::TEXT_DATA));

    $editorValue = $field->getEditorValue($color);
    $this->tester->assertArrayMembers([
      'alpha' => 'int',
      'blue'  => 'int',
      'green' => 'int',
      'red'   => 'int',
    ], $editorValue);

    $this->assertEquals($color->alpha, $editorValue['alpha']);
    $this->assertEquals($color->blue, $editorValue['blue']);
    $this->assertEquals($color->green, $editorValue['green']);
    $this->assertEquals($color->red, $editorValue['red']);
  }

  /**
   * @throws Throwable
   */
  public function testSwatches() {
    $invalidType = new ColorField(null, [
      'name' => 'invalidType',
      'type' => 'color',
      'swatches' => '@INVALID',
    ]);

    $invalidValue = new ColorField(null, [
      'name' => 'invalidValue',
      'type' => 'color',
      'swatches' => [
        '@INVALID'
      ],
    ]);

    $valid = new ColorField(null, [
      'name' => 'valid',
      'type' => 'color',
      'swatches' => [
        '#f0c',
        '#ff00cc'
      ],
    ]);

    $this->assertFalse($invalidType->validate());
    $this->assertFalse($invalidValue->validate());
    $this->assertTrue($valid->validate());
  }

  /**
   * @throws Throwable
   */
  public function testValue() {
    $field = $this->createField([
      'name' => 'testValue',
    ]);

    $this->assertInstanceOf(ColorValue::class, $field->createValue(true));
    $this->assertInstanceOf(ColorValue::class, $field->createValue(156));
    $this->assertInstanceOf(ColorValue::class, $field->createValue(self::TEXT_DATA));
    $this->assertInstanceOf(ColorValue::class, $field->createValue($this->createColorData()));
  }


  // Protected methods
  // -----------------

  /**
   * @return ColorValue
   */
  protected function createColor() {
    return new ColorValue($this->createColorData());
  }

  /**
   * @return array
   */
  protected function createColorData() {
    return [
      'alpha' => rand(0, 255),
      'blue'  => rand(0, 255),
      'green' => rand(0, 255),
      'red'   => rand(0, 255),
    ];
  }

  /**
   * @inheritDoc
   */
  protected function validateEditorData(array $editorData) {
    parent::validateEditorData($editorData);

    $this->tester->assertArrayMembers([
      'alpha'    => 'boolean',
      'swatches' => ['array', 'null'],
    ], $editorData);
  }
}
