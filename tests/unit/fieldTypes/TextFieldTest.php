<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\TextField;
use Throwable;

/**
 * Class TextFieldTest
 *
 * @method TextField createField(array $options)
 * @method TextField loadField(string $name, string $schema = null)
 */
class TextFieldTest extends AbstractStringFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_DEFAULT_SCHEMA = 'unit/fieldTypes/text';

  /**
   * @inheritDoc
   */
  const FIELD_CLASS = TextField::class;

  /**
   * @inheritDoc
   */
  const FIELD_OPTIONS = [
    'type' => TextField::NAME,
  ];


  /**
   * @throws Throwable
   */
  public function testEmail() {
    $field = $this->loadField('email');

    $this->assertEquals('email', $field->inputType);
    $this->assertCount(1, array_filter($field->getValueRules(), function($rule) {
      return $rule[0] == 'email';
    }));
  }

  /**
   * @throws Throwable
   */
  public function testUrl() {
    $field = $this->loadField('url');

    $this->assertEquals('url', $field->inputType);
    $this->assertCount(1, array_filter($field->getValueRules(), function($rule) {
      return $rule[0] == 'url';
    }));
  }
}
