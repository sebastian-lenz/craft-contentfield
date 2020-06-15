<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use Exception;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\Plugin;
use Throwable;
use UnitTester;

/**
 * Class AbstractFieldTest
 *
 * We collect test for the abstract base field class here, but the test
 * will be run on one of the actual subclasses. Prefer `TextField`.
 */
abstract class AbstractFieldTest extends \Codeception\Test\Unit
{
  /**
   * @var UnitTester
   */
  protected $tester;

  /**
   * @var string
   */
  const FIELD_CLASS = AbstractField::class;

  /**
   * @var string
   */
  const FIELD_DEFAULT_SCHEMA = '';

  /**
   * @var array
   */
  const FIELD_OPTIONS = [];

  /**
   * @var string
   */
  const TEXT_DATA = 'Phasellus viverra nulla ut';


  /**
   * @throws Throwable
   */
  public function testEditorData() {
    $field = $this->createField([
      'name' => 'testEditorData',
    ]);

    $this->validateEditorData($field->getEditorData());
  }

  /**
   * @throws Throwable
   */
  public function testLabel() {
    $field = $this->createField([
      'label' => static::TEXT_DATA,
      'name'  => 'testLabel',
    ]);

    $this->assertEquals(static::TEXT_DATA, $field->label);
  }

  /**
   * @throws Throwable
   */
  public function testLabelGeneration() {
    $field = $this->createField([
      'name' => 'testLabelGeneration',
    ]);

    $this->assertEquals('Test Label Generation', $field->label);
  }

  /**
   * @throws Throwable
   */
  public function testNameException() {
    $this->expectException(Exception::class);
    $this->createField([]);
  }


  // Protected methods
  // -----------------

  /**
   * @param array $options
   * @return AbstractField
   */
  protected function createField(array $options) {
    $fieldClass = static::FIELD_CLASS;
    $field = new $fieldClass(null, array_merge(
      static::FIELD_OPTIONS,
      $options
    ));

    if (!$field->validate()) {
      $this->fail('Field is not valid: ' . implode(' ', $field->getErrorSummary(true)));
    }

    return $field;
  }

  /**
   * @param string $name
   * @param string|null $schema
   * @return AbstractField
   * @throws Exception
   */
  protected function loadField(string $name, string $schema = null) {
    $field = $this->loadSchema($schema)->getField($name);

    $this->assertInstanceOf(static::FIELD_CLASS, $field);
    $this->assertEquals($name, $field->name);
    $this->validateEditorData($field->getEditorData());

    return $field;
  }

  /**
   * @param string|null $schema
   * @return AbstractSchema|null
   * @throws Exception
   */
  protected function loadSchema(string $schema = null) {
    return Plugin::getInstance()->schemas->getSchema(is_null($schema)
      ? static::FIELD_DEFAULT_SCHEMA
      : $schema
    );
  }

  /**
   * @param array $editorData
   */
  protected function validateEditorData(array $editorData) {
    $this->tester->assertArrayMembers([
      'group'        => ['array', 'null'],
      'instructions' => ['string', 'null'],
      'isRequired'   => 'boolean',
      'label'        => 'string',
      'name'         => 'string',
      'validatorId'  => ['string', 'null'],
      'style'        => ['array', 'null'],
      'type'         => 'string',
    ], $editorData);
  }
}
