<?php

namespace lenz\contentfield\services\fieldUsages;

use craft\base\ElementInterface;
use craft\elements\Category;
use craft\models\FieldLayout;
use craft\records\CategoryGroup;
use craft\records\FieldLayoutField;

/**
 * Class CategoryAdapter
 */
class CategoryAdapter extends AbstractAdapter
{
  /**
   * @inheritDoc
   */
  public function createUsages(Usage $scope, FieldLayout $layout, FieldLayoutField $layoutField) {
    if ($layout->type == Category::class) {
      $group = CategoryGroup::findOne([
        'fieldLayoutId' => $layoutField->layoutId,
      ]);

      if (is_null($group)) {
        return;
      }

      $scope->findOrCreate([
        'name' => $group->name,
        'type' => 'categoryGroup',
        'uid'  => $group->uid,
      ]);
    }
  }

  /**
   * @inheritDoc
   */
  public function toUids(ElementInterface $element = null): ?array {
    if ($element instanceof Category) {
      return [$element->getGroup()->uid];
    }

    return null;
  }
}
