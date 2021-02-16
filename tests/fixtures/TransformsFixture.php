<?php

namespace lenz\contentfield\tests\fixtures;

use Craft;
use craft\records\AssetTransform;
use craft\services\AssetTransforms;
use craft\test\Fixture;

/**
 * Class TransformsFixture
 */
class TransformsFixture extends Fixture
{
  /**
   * @inheritdoc
   */
  public $dataFile = __DIR__ . '/data/transforms.php';

  /**
   * @inheritdoc
   */
  public $modelClass = AssetTransform::class;

  /**
   * @inheritdoc
   */
  public function load() {
    parent::load();
    Craft::$app->set('assetTransforms', new AssetTransforms());
  }
}
