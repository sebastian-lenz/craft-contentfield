<?php

namespace lenz\contentfield\models;

use lenz\contentfield\utilities\ReferenceMap;

/**
 * Interface ReferenceMapValueInterface
 */
interface ReferenceMapValueInterface
{
  /**
   * Return a list of all referenced entries by this field.
   *
   * @param ReferenceMap $map
   * @return ReferenceMap
   */
  public function getReferenceMap(ReferenceMap $map = null);
}
