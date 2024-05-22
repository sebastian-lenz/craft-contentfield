<?php

namespace lenz\contentfield\services\fieldUsages;

use craft\base\ElementInterface;
use craft\base\Field;
use craft\elements\GlobalSet;
use craft\models\FieldLayout;
use craft\records\GlobalSet as GlobalSetRecord;

/**
 * Class GlobalSetAdapter
 */
class GlobalSetAdapter extends AbstractAdapter
{
  /**
   * @inheritDoc
   */
  public function createUsages(Field $field, Usage $scope, FieldLayout $layout): bool {
    if ($layout->type != GlobalSet::class) {
      return false;
    }

    $globalSet = GlobalSetRecord::findOne(['fieldLayoutId' => $layout->id]);
    if (is_null($globalSet)) {
      return false;
    }

    $scope->findOrCreate([
      'name' => $globalSet->name,
      'type' => 'globalSet',
      'uid'  => $globalSet->uid,
    ]);

    return true;
  }

  /**
   * @inheritDoc
   */
  public function toUids(ElementInterface $element = null): ?array {
    if ($element instanceof GlobalSet) {
      return [
        $element->uid
      ];
    }

    return null;
  }
}
