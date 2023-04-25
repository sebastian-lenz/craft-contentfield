<?php

namespace lenz\contentfield\models\enumerations;

use craft\base\ElementInterface;

/**
 * Interface ElementEnumerationInterface
 */
interface ElementEnumerationInterface extends EnumerationInterface
{
  /**
   * Return an array of all options.
   * @param ElementInterface|null $element
   * @return array
   */
  function getElementOptions(?ElementInterface $element): array;
}
