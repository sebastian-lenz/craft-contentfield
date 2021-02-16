<?php

namespace lenz\contentfield\tests\fixtures;

use craft\models\FieldLayout;
use craft\test\fixtures\FieldLayoutFixture as BaseFieldLayoutFixture;

/**
 * Class FieldLayoutFixture
 */
class FieldLayoutFixture extends BaseFieldLayoutFixture
{
  /**
   * @inheritdoc
   */
  public $dataFile = __DIR__ . '/data/field-layout.php';

  /**
   * @inheritdoc
   */
  public $modelClass = FieldLayout::class;
}
