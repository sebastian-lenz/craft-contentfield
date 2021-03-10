<?php

namespace lenz\contentfield\tests\fixtures;

use craft\test\fixtures\elements\UserFixture;

/**
 * Class UsersFixture
 */
class UsersFixture extends UserFixture
{
  /**
   * @inheritdoc
   */
  public $dataFile = __DIR__ . '/data/users.php';

  /**
   * @inheritdoc
   */
  public $depends = [FieldLayoutFixture::class];
}
