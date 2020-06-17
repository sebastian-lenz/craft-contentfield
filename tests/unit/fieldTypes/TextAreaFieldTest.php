<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\TextAreaField;

/**
 * Class TextAreaFieldTest
 *
 * @method TextAreaField createField(array $options)
 * @method TextAreaField loadField(string $name, string $schema = null)
 */
class TextAreaFieldTest extends AbstractStringFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = TextAreaField::class;

  /**
   * @inheritDoc
   */
  const FIELD_OPTIONS = [
    'type' => TextAreaField::NAME,
  ];


  // Protected methods
  // -----------------

  protected function validateEditorData(array $editorData) {
    parent::validateEditorData($editorData);

    $this->tester->assertArrayMembers([
      'monospace'   => 'boolean',
      'placeholder' => 'string',
      'rows'        => 'int',
    ], $editorData);
  }
}
