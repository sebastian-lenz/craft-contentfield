<?php

namespace lenz\contentfield\services\fieldUsages;

use craft\base\ElementInterface;
use craft\base\Field;
use craft\elements\Category;
use craft\models\FieldLayout;
use craft\records\CategoryGroup;

/**
 * Class CategoryAdapter
 */
class CategoryAdapter extends AbstractAdapter
{
  /**
   * @inheritDoc
   */
  public function createUsages(Field $field, Usage $scope, FieldLayout $layout): bool {
    if ($layout->type != Category::class) {
      return false;
    }

    $group = CategoryGroup::findOne(['fieldLayoutId' => $layout->id]);
    if (is_null($group)) {
      return false;
    }

    $scope->findOrCreate([
      'name' => $group->name,
      'type' => 'categoryGroup',
      'uid'  => $group->uid,
    ]);

    return true;
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
