<?php

namespace lenz\contentfield\tests\fixtures;

use craft\records\EntryType;
use craft\test\Fixture;

/**
 * Class EntryTypeFixture
 */
class EntryTypeFixture extends Fixture
{
  /**
   * @inheritdoc
   */
  public $dataFile = __DIR__ . '/data/entry-types.php';

  /**
   * @inheritdoc
   */
  public $modelClass = EntryType::class;

  /**
   * @inheritdoc
   */
  public $depends = [FieldLayoutFixture::class, SectionsFixture::class];
}
