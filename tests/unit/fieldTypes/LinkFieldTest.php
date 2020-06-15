<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\LinkField;
use lenz\contentfield\models\values\LinkValue;
use Throwable;

/**
 * Class LinkFieldTest
 *
 * @method LinkField createField(array $options)
 * @method LinkField loadField(string $name, string $schema = null)
 */
class LinkFieldTest extends AbstractFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = LinkField::class;

  /**
   * @inheritDoc
   */
  const FIELD_OPTIONS = [
    'type' => LinkField::NAME
  ];


  /**
   * @throws Throwable
   */
  public function testEditorValue() {
    $link = $this->createElementLink();
    $field = $this->createField([
      'name' => 'testEditorValue',
    ]);

    $this->assertNull($field->getEditorValue(self::TEXT_DATA));

    $editorValue = $field->getEditorValue($link);
    $this->tester->assertArrayMembers([
      'elementId'       => 'int',
      'hash'            => 'string',
      'openInNewWindow' => 'boolean',
      'type'            => 'string',
      'url'             => 'string',
    ], $editorValue);
  }

  /**
   * @throws Throwable
   */
  public function testValue() {
    $field = $this->createField([
      'name' => 'testValue',
    ]);

    $this->assertInstanceOf(LinkValue::class, $field->createValue(true));
    $this->assertInstanceOf(LinkValue::class, $field->createValue(156));
    $this->assertInstanceOf(LinkValue::class, $field->createValue(self::TEXT_DATA));
    $this->assertInstanceOf(LinkValue::class, $field->createValue($this->createElementLinkData()));
  }


  // Protected methods
  // -----------------

  /**
   * @return LinkValue
   */
  protected function createElementLink() {
    return new LinkValue($this->createElementLinkData());
  }

  /**
   * @return array
   */
  protected function createElementLinkData() {
    return [
      'elementId' => 1,
      'type'      => 'entry'
    ];
  }

  /**
   * @inheritDoc
   */
  protected function validateEditorData(array $editorData) {
    parent::validateEditorData($editorData);

    $this->tester->assertArrayMembers([
      'allowNewWindow' => 'boolean',
      'linkTypes'      => 'array',
    ], $editorData);
  }
}
