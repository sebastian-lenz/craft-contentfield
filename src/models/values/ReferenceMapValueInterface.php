<?php

namespace lenz\contentfield\models\values;

use lenz\contentfield\helpers\ReferenceMap;

/**
 * Interface ReferenceMapValueInterface
 */
interface ReferenceMapValueInterface
{
  /**
   * Return a list of all referenced entries by this field.
   *
   * @param \lenz\contentfield\helpers\ReferenceMap $map
   * @return ReferenceMap
   */
  public function getReferenceMap(ReferenceMap $map = null);
}
