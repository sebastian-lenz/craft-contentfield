<?php

namespace lenz\contentfield\services\fieldUsages;

use craft\base\ElementInterface;
use craft\base\Field;
use craft\models\FieldLayout;
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
   * @param Field $field
   * @param Usage $scope
   * @param FieldLayout $layout
   * @return bool
   */
  abstract function createUsages(Field $field, Usage $scope, FieldLayout $layout): bool;

  /**
   * @param ElementInterface|null $element
   * @return array|null
   * @throws Throwable
   */
  abstract function toUids(ElementInterface $element = null): ?array;
}
