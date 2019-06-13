<?php

namespace lenz\contentfield\utilities;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\elements\Entry;
use craft\records\EntryType;
use craft\records\FieldLayoutField;
use Throwable;
use yii\BaseYii;

/**
 * Class FieldUsage
 */
class FieldUsage
{
  /**
   * @var FieldUsage[]
   */
  public $children = [];

  /**
   * @var string
   */
  public $name;

  /**
   * @var string
   */
  public $type;

  /**
   * @var string
   */
  public $uid;


  /**
   * FieldUsage constructor.
   * @param array $options
   */
  public function __construct($options = []) {
    BaseYii::configure($this, $options);
  }


  // Private methods
  // --------------

  private function addLayoutField(FieldLayoutField $layoutField) {
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

    $this->findOrCreate([
      'name' => $section->name,
      'type' => 'section',
      'uid'  => $section->uid,
    ])->findOrCreate([
      'name' => $entryType->name,
      'type' => 'entryType',
      'uid'  => $entryType->uid,
    ]);
  }

  /**
   * @param array $options
   * @return FieldUsage
   */
  private function findOrCreate($options) {
    if (!is_array($this->children)) {
      $this->children = [];
    }

    foreach ($this->children as $child) {
      if ($child->uid == $options['uid']) {
        return $child;
      }
    }

    $child = new FieldUsage($options);
    $this->children[] = $child;
    return $child;
  }

  /**
   * @return FieldUsage[]
   */
  private function getFlattened() {
    $result = [];
    foreach ($this->children as $child) {
      $result[] = $child;
      $result = array_merge($result, $child->getFlattened());
    }

    return $result;
  }

  /**
   * @return void
   */
  private function sortChildren() {
    if (!is_array($this->children)) {
      return;
    }

    uasort($this->children, function(FieldUsage $a, FieldUsage $b) {
      return strcmp($a->name, $b->name);
    });

    foreach ($this->children as $child) {
      $child->sortChildren();
    }
  }


  // Static methods
  // --------------

  /**
   * @param Field $field
   * @return FieldUsage[]
   */
  static function forField(Field $field) {
    $usage = new FieldUsage();
    $layoutFields = FieldLayoutField::findAll([
      'fieldId' => $field->id
    ]);

    foreach ($layoutFields as $layoutField) {
      $usage->addLayoutField($layoutField);
    }

    $usage->sortChildren();
    return $usage->getFlattened();
  }

  /**
   * @param ElementInterface|null $element
   * @return string[]
   */
  static function toUids(ElementInterface $element = null) {
    try {
      if ($element instanceof Entry) {
        return [
          $element->getType()->uid,
          $element->getSection()->uid,
        ];
      }
    } catch (Throwable $error) {
      Craft::error($error->getMessage());
    }

    return [];
  }
}
