<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use Exception;
use lenz\contentfield\models\enumerations\VolumeFolderEnumeration;
use lenz\contentfield\models\fields\SelectField;
use Throwable;

/**
 * Class SelectFieldTest
 *
 * @method SelectField createField(array $options)
 * @method SelectField loadField(string $name, string $schema = null)
 */
class SelectFieldTest extends AbstractEnumerationFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = SelectField::class;

  /**
   * @inheritDoc
   */
  const FIELD_DEFAULT_SCHEMA = 'unit/fieldTypes/select';

  /**
   * @inheritDoc
   */
  const FIELD_OPTIONS = [
    'type' => SelectField::NAME,
  ];


  /**
   * @throws Exception
   */
  public function testVolumeFolder() {
    $field = $this->loadField('volumeFolder');

    $this->assertInstanceOf(VolumeFolderEnumeration::class, $field->getEnumeration());
  }
}
