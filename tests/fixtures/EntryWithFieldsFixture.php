<?php

namespace lenz\contentfield\tests\fixtures;

use craft\test\fixtures\elements\EntryFixture as BaseEntriesFixture;

/**
 * Class EntryWithFieldsFixture
 */
class EntryWithFieldsFixture extends BaseEntriesFixture
{
  /**
   * @inheritdoc
   */
  public $dataFile = __DIR__ . '/data/entry-with-fields.php';

  /**
   * @inheritdoc
   */
  public $depends = [FieldLayoutFixture::class, SectionsFixture::class, EntryTypeFixture::class];
}
