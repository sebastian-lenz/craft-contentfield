<?php

namespace lenz\contentfield\tests\fixtures;

use craft\test\fixtures\elements\EntryFixture as BaseEntriesFixture;

/**
 * Class EntryFixture
 */
class EntryFixture extends BaseEntriesFixture
{
  /**
   * @inheritdoc
   */
  public $dataFile = __DIR__ . '/data/entries.php';

  /**
   * @inheritdoc
   */
  public $depends = [SectionsFixture::class, EntryTypeFixture::class];
}
