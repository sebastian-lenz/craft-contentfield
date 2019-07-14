<?php

namespace lenz\contentfield\services\fieldUsages;

use craft\base\ElementInterface;
use craft\elements\GlobalSet;
use craft\models\FieldLayout;
use craft\records\FieldLayoutField;
use craft\records\GlobalSet as GlobalSetRecord;

/**
 * Class GlobalSetAdapter
 */
class GlobalSetAdapter extends AbstractAdapter
{
  /**
   * @inheritDoc
   */
  public function createUsages(Usage $scope, FieldLayout $layout, FieldLayoutField $layoutField) {
    if ($layout->type == GlobalSet::class) {
      $globalSet = GlobalSetRecord::findOne([
        'fieldLayoutId' => $layoutField->layoutId,
      ]);

      if (is_null($globalSet)) {
        return;
      }

      $scope->findOrCreate([
        'name' => $globalSet->name,
        'type' => 'globalSet',
        'uid'  => $globalSet->uid,
      ]);
    }
  }

  /**
   * @inheritDoc
   */
  public function toUids(ElementInterface $element = null) {
    if ($element instanceof GlobalSet) {
      return [
        $element->uid
      ];
    }

    return null;
  }
}
