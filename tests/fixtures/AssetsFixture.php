<?php

namespace lenz\contentfield\tests\fixtures;

use craft\test\fixtures\elements\AssetFixture;

/**
 * Class AssetsFixture.
 */
class AssetsFixture extends AssetFixture
{
  /**
   * @inheritdoc
   */
  public $dataFile = __DIR__ . '/data/assets.php';

  /**
   * @inheritdoc
   */
  public $depends = [VolumesFixture::class, VolumesFolderFixture::class];
}
