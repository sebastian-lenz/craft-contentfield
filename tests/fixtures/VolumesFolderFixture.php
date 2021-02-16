<?php

namespace lenz\contentfield\tests\fixtures;

use Craft;
use craft\records\VolumeFolder;
use craft\services\Volumes;
use craft\test\Fixture;

/**
 * Class VolumeFolderFixture.
 */
class VolumesFolderFixture extends Fixture
{
  /**
   * @inheritdoc
   */
  public $modelClass = VolumeFolder::class;

  /**
   * @inheritdoc
   */
  public $dataFile = __DIR__ . '/data/volumefolder.php';

  /**
   * @inheritdoc
   */
  public $depends = [VolumesFixture::class];

  /**
   * @inheritdoc
   */
  public function load() {
    parent::load();
    Craft::$app->set('volumes', new Volumes());
  }
}
