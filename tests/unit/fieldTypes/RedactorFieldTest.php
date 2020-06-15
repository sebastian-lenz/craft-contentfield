<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\RedactorField;
use lenz\contentfield\models\values\RedactorValue;
use Throwable;

/**
 * Class RedactorFieldTest
 *
 * @method RedactorField createField(array $options)
 * @method RedactorField loadField(string $name, string $schema = null)
 */
class RedactorFieldTest extends AbstractFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = RedactorField::class;

  /**
   * @inheritDoc
   */
  const FIELD_OPTIONS = [
    'type' => RedactorField::NAME
  ];

  /**
   * @var string
   */
  const HTML_DATA = '<h1>Fusce vel dui</h1><p>Nam quam nunc<br>blandit vel</p>';


  /**
   * @throws Throwable
   */
  public function testEditorValue() {
    $redactor = $this->createRedactor();
    $field = $this->createField([
      'name' => 'testEditorValue',
    ]);

    $this->assertNull($field->getEditorValue(null));
    $this->assertNull($field->getEditorValue(1024));
    $this->assertNull($field->getEditorValue(self::TEXT_DATA));

    $editorValue = $field->getEditorValue($redactor);
    $this->assertIsString($editorValue);
    $this->assertEquals(self::HTML_DATA, $editorValue);
  }

  /**
   * @throws Throwable
   */
  public function testNotSearchable() {
    $field = $this->createField([
      'name' => 'testNotSearchable',
      'searchable' => false,
    ]);

    $this->assertFalse($field->searchable);
    $this->assertEquals('', $field->getSearchKeywords(self::TEXT_DATA));
  }

  /**
   * @throws Throwable
   */
  public function testSearchable() {
    $field = $this->createField([
      'name' => 'testSearchable',
    ]);

    $this->assertTrue($field->searchable);
    $this->assertIsString($field->getSearchKeywords(1024));
    $this->assertIsString($field->getSearchKeywords($this->createRedactor()));
  }

  /**
   * @throws Throwable
   */
  public function testSerializedValue() {
    $field = $this->createField([
      'name' => 'testSerializedValue',
    ]);

    $this->assertNull($field->getSerializedValue(1024));
    $this->assertNull($field->getSerializedValue(true));
    $this->assertNull($field->getSerializedValue(self::TEXT_DATA));
    $this->assertIsString($field->getSerializedValue($this->createRedactor()));
  }

  /**
   * @throws Throwable
   */
  public function testValue() {
    $field = $this->createField([
      'name' => 'testValue',
    ]);

    $this->assertInstanceOf(RedactorValue::class, $field->createValue(true));
    $this->assertInstanceOf(RedactorValue::class, $field->createValue(156));
    $this->assertInstanceOf(RedactorValue::class, $field->createValue(self::HTML_DATA));
  }


  // Protected methods
  // -----------------

  /**
   * @return RedactorValue
   */
  protected function createRedactor() {
    return new RedactorValue(self::HTML_DATA);
  }

  /**
   * @inheritDoc
   */
  protected function validateEditorData(array $editorData) {
    parent::validateEditorData($editorData);

    $this->tester->assertArrayMembers([
      'redactor'     => 'array',
      'translatable' => 'boolean',
    ], $editorData);
  }
}
