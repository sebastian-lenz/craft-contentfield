<?php

namespace lenz\contentfield\tests\fixtures;

use Craft;
use craft\records\UserGroup;
use craft\services\UserGroups;
use craft\test\Fixture;
use yii\base\Exception;

/**
 * Class UserGroupsFixture.
 */
class UserGroupsFixture extends Fixture
{
  /**
   * @inheritdoc
   */
  public $modelClass = UserGroup::class;

  /**
   * @inheritdoc
   */
  public $dataFile = __DIR__ . '/data/user-groups.php';

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function load() {
    parent::load();
    Craft::$app->set('userGroups', new UserGroups());
  }
}
