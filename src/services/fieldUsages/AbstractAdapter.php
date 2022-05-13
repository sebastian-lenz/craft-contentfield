<?php

namespace lenz\contentfield\services\fieldUsages;

use craft\base\ElementInterface;
use craft\models\FieldLayout;
use craft\records\FieldLayoutField;
use Throwable;

/**
 * Class AbstractAdapter
 *
 * Base class of all field usage adapters. Adapters are used
 * to implement the logic required to resolve the involved uids
 * for different element types.
 */
abstract class AbstractAdapter
{
  /**
   * @param Usage $scope
   * @param FieldLayout $layout
   * @param FieldLayoutField $layoutField
   */
  abstract function createUsages(Usage $scope, FieldLayout $layout, FieldLayoutField $layoutField): void;

  /**
   * @param ElementInterface|null $element
   * @return array|null
   * @throws Throwable
   */
  abstract function toUids(ElementInterface $element = null): ?array;
}
