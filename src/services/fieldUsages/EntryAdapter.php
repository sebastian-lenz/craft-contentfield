<?php

namespace lenz\contentfield\services\fieldUsages;

use craft\base\ElementInterface;
use craft\base\Field;
use craft\elements\Entry;
use craft\models\FieldLayout;
use craft\models\Section;
use craft\records\EntryType;

/**
 * Class EntryAdapter
 */
class EntryAdapter extends AbstractAdapter
{
  /**
   * @inheritDoc
   */
  public function createUsages(Field $field, Usage $scope, FieldLayout $layout): bool {
    if ($layout->type != Entry::class) {
      return false;
    }

    $entryType = EntryType::findOne(['fieldLayoutId' => $layout->id]);
    if (is_null($entryType)) {
      return false;
    }

    foreach (self::getSections($entryType->id) as $section) {
      $scope->findOrCreate([
        'name' => $section->name,
        'type' => 'section',
        'uid'  => $section->uid,
      ]);
    }

    $scope->findOrCreate([
      'name' => $entryType->name,
      'type' => 'entryType',
      'uid'  => $entryType->uid,
    ]);

    return true;
  }

  /**
   * @inheritDoc
   */
  public function toUids(ElementInterface $element = null): ?array {
    if ($element instanceof Entry) {
      return [
        $element->getType()->uid,
        $element->getSection()->uid,
      ];
    }

    return null;
  }


  // Static methods
  // --------------

  /**
   * @param int $entryTypeId
   * @return Section[]
   */
  private static function getSections(int $entryTypeId): array {
    return array_filter(
      \Craft::$app->entries->getAllSections(),
      function(Section $section) use ($entryTypeId) {
        foreach ($section->entryTypes as $entryType) {
          if ($entryType->id == $entryTypeId) {
            return true;
          }
        }

        return false;
      }
    );
  }
}
