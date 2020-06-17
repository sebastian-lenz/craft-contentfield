<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\AbstractStringField;
use Throwable;

/**
 * Class AbstractStringFieldTest
 *
 * @method AbstractStringField createField(array $options)
 * @method AbstractStringField loadField(string $name, string $schema = null)
 */
abstract class AbstractStringFieldTest extends AbstractFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = AbstractStringField::class;


  /**
   * @throws Throwable
   */
  public function testEditorValue() {
    $field = $this->createField([
      'name' => 'testEditorValue',
    ]);

    $this->assertEquals(self::TEXT_DATA, $field->getEditorValue(self::TEXT_DATA));
    $this->assertNull($field->getEditorValue([true]));
  }

  /**
   * @throws Throwable
   */
  public function testMinMax() {
    $field = $this->createField([
      'maxLength' => 10,
      'minLength' => 5,
      'name'      => 'testMinMax',
    ]);

    $this->assertEquals(5, $field->minLength);
    $this->assertEquals(10, $field->maxLength);

    $this->assertCount(1, array_filter(
      $field->getValueRules(),
      function($rule) {
        if (!is_array($rule) || $rule[0] != 'string') return false;
        $this->assertEquals(5, $rule['min']);
        $this->assertEquals(10, $rule['max']);
        return true;
      }
    ));
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
  public function testNotTranslatable() {
    $field = $this->createField([
      'name' => 'testNotTranslatable',
      'translatable' => false,
    ]);

    $this->assertFalse($field->translatable);
  }

  /**
   * @throws Throwable
   */
  public function testPattern() {
    $pattern = '^test.*';
    $field = $this->createField([
      'pattern' => $pattern,
      'name'    => 'testPattern',
    ]);

    $this->assertEquals($pattern, $field->pattern);
    $this->assertCount(1, array_filter(
      $field->getValueRules(),
      function($rule) use ($pattern) {
        if (!is_array($rule) || $rule[0] != 'match') return false;
        $this->assertEquals($pattern, $rule['pattern']);
        return true;
      }
    ));
  }

  /**
   * @throws Throwable
   */
  public function testSearchable() {
    $field = $this->createField([
      'name' => 'testSearchable',
    ]);

    $this->assertTrue($field->searchable);
    $this->assertEquals(self::TEXT_DATA, $field->getSearchKeywords(self::TEXT_DATA));
    $this->assertIsString($field->getSearchKeywords(1024));
    $this->assertIsString($field->getSearchKeywords([true]));
  }

  /**
   * @throws Throwable
   */
  public function testTranslatable() {
    $field = $this->createField([
      'name' => 'testTranslatable',
    ]);

    $this->assertTrue($field->translatable);
  }

  /**
   * @throws Throwable
   */
  public function testValue() {
    $field = $this->createField([
      'name' => 'testValue',
    ]);

    $this->assertEquals(self::TEXT_DATA, $field->createValue(self::TEXT_DATA));
    $this->assertNull($field->createValue([true]));
  }


  // Protected methods
  // -----------------

  /**
   * @inheritDoc
   */
  protected function validateEditorData(array $editorData) {
    parent::validateEditorData($editorData);

    $this->tester->assertArrayMembers([
      'maxLength'    => ['int', 'null'],
      'minLength'    => ['int', 'null'],
      'translatable' => 'boolean',
    ], $editorData);
  }
}
