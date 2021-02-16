<?php

namespace lenz\contentfield\tests\fixtures;

use craft\records\Section_SiteSettings;
use craft\test\Fixture;

/**
 * Class SectionSettingFixture
 */
class SectionSettingFixture extends Fixture
{
  /**
   * @inheritdoc
   */
  public $dataFile = __DIR__ . '/data/section-settings.php';

  /**
   * @inheritdoc
   */
  public $modelClass = Section_SiteSettings::class;

  /**
   * @inheritdoc
   */
  public $depends = [SitesFixture::class];
}
