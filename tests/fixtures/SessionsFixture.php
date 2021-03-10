<?php

namespace lenz\contentfield\tests\fixtures;

use craft\records\Session;
use craft\test\Fixture;

/**
 * Class SessionsFixture
 */
class SessionsFixture extends Fixture
{
  /**
   * @inheritdoc
   */
  public $dataFile = __DIR__ . '/data/sessions.php';

  /**
   * @inheritdoc
   */
  public $modelClass = Session::class;
}
