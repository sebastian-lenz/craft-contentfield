<?php

namespace lenz\contentfield\services;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\records\FieldLayoutField;
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
  protected $_adapters;


  /**
   * FieldUsage constructor.
   */
  public function __construct() {
    $adapters = [
      new fieldUsages\EntryAdapter(),
      new fieldUsages\GlobalSetAdapter(),
      new fieldUsages\CategoryAdapter(),
    ];

    $plugins = Craft::$app->getPlugins();
    if ($plugins->isPluginEnabled('calendar')) {
      $adapters[] = new fieldUsages\SolspaceCalendarAdapter();
    }

    $this->_adapters = $adapters;
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
    $layoutFields = FieldLayoutField::findAll([
      'fieldId' => $field->id
    ]);

    foreach ($layoutFields as $layoutField) {
      if (is_null($layoutField->layoutId)) {
        continue;
      }

      $layout = $fields->getLayoutById($layoutField->layoutId);
      if (is_null($layout)) {
        continue;
      }

      foreach ($this->_adapters as $adapter) {
        $adapter->createUsages($usage, $layout, $layoutField);
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
      } catch (Throwable $error) {
        $result = null;
      }

      if (!is_null($result)) {
        return $result;
      }
    }

    return [];
  }
}
