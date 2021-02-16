<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use craft\elements\Entry;
use lenz\contentfield\models\fields\ReferenceField;
use lenz\contentfield\models\values\ReferenceValue;
use lenz\contentfield\tests\fixtures\EntryFixture;
use Throwable;

/**
 * Class ReferenceFieldTest
 *
 * @method ReferenceField createField(array $options)
 * @method ReferenceField loadField(string $name, string $schema = null)
 */
class ReferenceFieldTest extends AbstractFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = ReferenceField::class;

  /**
   * @inheritDoc
   */
  const FIELD_OPTIONS = [
    'type' => ReferenceField::NAME
  ];


  /**
   * @return array
   */
  public function _fixtures(): array {
    return [
      'entries' => [
        'class' => EntryFixture::class
      ],
    ];
  }

  /**
   * @throws Throwable
   */
  public function testEditorValue() {
    $field = $this->createField([
      'name' => 'testEditorValue',
    ]);

    $entry = Entry::findOne(['section' => 'test1']);
    $this->assertInstanceOf(Entry::class, $entry);

    $this->assertNull($field->getEditorValue(null));
    $this->assertNull($field->getEditorValue(1024));
    $this->assertNull($field->getEditorValue(self::TEXT_DATA));

    $reference = new ReferenceValue([$entry->id], null, $field);
    $editorValue = $field->getEditorValue($reference);
    $this->assertIsArray($editorValue);
    $this->assertEquals([$entry->id], $editorValue);
  }

  /**
   * @throws Throwable
   */
  public function testValue() {
    $field = $this->createField([
      'name' => 'testValue',
    ]);

    $this->assertInstanceOf(ReferenceValue::class, $field->createValue(true));
    $this->assertInstanceOf(ReferenceValue::class, $field->createValue(156));
    $this->assertInstanceOf(ReferenceValue::class, $field->createValue([1, 2]));
  }


  // Protected methods
  // -----------------

  /**
   * @inheritDoc
   */
  protected function validateEditorData(array $editorData) {
    parent::validateEditorData($editorData);

    $this->tester->assertArrayMembers([
      'criteria'        => 'array',
      'elementType'     => 'string',
      'limit'           => ['null', 'int'],
      'modalStorageKey' => ['null', 'string'],
      'sources'         => ['null', 'array'],
      'viewMode'        => 'string',
    ], $editorData);
  }
}
