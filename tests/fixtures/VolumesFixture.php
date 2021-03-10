<?php

namespace lenz\contentfield\tests\fixtures;

use Craft;
use craft\helpers\FileHelper;
use craft\helpers\Json;
use craft\records\Volume;
use craft\services\Volumes;
use craft\test\Fixture;
use yii\base\ErrorException;
use yii\base\Exception;

/**
 * Class VolumesFixture.
 */
class VolumesFixture extends Fixture
{
  const BASE_URL = 'https://cdn.test.craftcms.test/';

  /**
   * @inheritdoc
   */
  public $modelClass = Volume::class;

  /**
   * @inheritdoc
   */
  public $dataFile = __DIR__ . '/data/volumes.php';

  /**
   * @inheritdoc
   */
  public $depends = [FieldLayoutFixture::class];

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function load() {
    parent::load();

    // Create the dirs
    foreach ($this->getData() as $data) {
      $settings = Json::decodeIfJson($data['settings']);
      FileHelper::createDirectory($settings['path']);
    }

    Craft::$app->set('volumes', new Volumes());
  }

  /**
   * @inheritdoc
   * @throws ErrorException
   */
  public function unload() {
    // Remove the dirs
    foreach ($this->getData() as $data) {
      $settings = Json::decodeIfJson($data['settings']);
      FileHelper::removeDirectory($settings['path']);
    }

    parent::unload();
  }
}
