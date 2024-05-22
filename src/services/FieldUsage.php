<?php

namespace lenz\contentfield\services;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use lenz\contentfield\services\fieldUsages\AbstractAdapter;
use Throwable;

/**
 * Class FieldUsage
 */
class FieldUsage
{
  /**
   * @var AbstractAdapter[]
   */
  protected array $_adapters;


  /**
   * FieldUsage constructor.
   */
  public function __construct() {
    $this->_adapters = [
      new fieldUsages\EntryAdapter(),
      new fieldUsages\GlobalSetAdapter(),
      new fieldUsages\CategoryAdapter(),
    ];
  }

  /**
   * Returns a list of FieldUsage instances that describe the elements
   * that use the given field within their field layouts.
   *
   * @param Field $field
   * @return fieldUsages\Usage[]
   */
  public function findUsages(Field $field): array {
    $usage = new fieldUsages\Usage();
    $fields = Craft::$app->getFields();

    $layouts = $fields->findFieldUsages($field);
    foreach ($layouts as $layout) {
      foreach ($this->_adapters as $adapter) {
        $adapter->createUsages($field, $usage, $layout);
      }
    }

    $usage->sortChildren();
    return $usage->getFlattened();
  }

  /**
   * Returns all uids assigned to the given element.
   *
   * @param ElementInterface|null $element
   * @return string[]
   */
  public function toUids(ElementInterface $element = null): array {
    foreach ($this->_adapters as $adapter) {
      try {
        $result = $adapter->toUids($element);
      } catch (Throwable) {
        $result = null;
      }

      if (!is_null($result)) {
        return $result;
      }
    }

    return [];
  }
}
