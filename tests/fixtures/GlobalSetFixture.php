<?php

namespace lenz\contentfield\tests\fixtures;

use craft\test\fixtures\elements\GlobalSetFixture as BaseGlobalSetFixture;

/**
 * Class GlobalSetFixture
 */
class GlobalSetFixture extends BaseGlobalSetFixture
{
  /**
   * @inheritdoc
   */
  public $dataFile = __DIR__ . '/data/global-sets.php';
}
