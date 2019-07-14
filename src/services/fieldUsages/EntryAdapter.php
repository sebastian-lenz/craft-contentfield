<?php

namespace lenz\contentfield\services\fieldUsages;

use craft\base\ElementInterface;
use craft\elements\Entry;
use craft\models\FieldLayout;
use craft\records\EntryType;
use craft\records\FieldLayoutField;

/**
 * Class EntryAdapter
 */
class EntryAdapter extends AbstractAdapter
{
  /**
   * @inheritDoc
   */
  public function createUsages(Usage $scope, FieldLayout $layout, FieldLayoutField $layoutField) {
    if ($layout->type == Entry::class) {
      $entryType = EntryType::findOne([
        'fieldLayoutId' => $layoutField->layoutId,
      ]);

      if (is_null($entryType)) {
        return;
      }

      $section = $entryType->section;
      if (is_null($section)) {
        return;
      }

      $scope->findOrCreate([
        'name' => $section->name,
        'type' => 'section',
        'uid'  => $section->uid,
      ])->findOrCreate([
        'name' => $entryType->name,
        'type' => 'entryType',
        'uid'  => $entryType->uid,
      ]);
    }
  }

  /**
   * @inheritDoc
   */
  public function toUids(ElementInterface $element = null) {
    if ($element instanceof Entry) {
      return [
        $element->getType()->uid,
        $element->getSection()->uid,
      ];
    }

    return null;
  }
}
