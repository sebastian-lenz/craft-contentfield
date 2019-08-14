<?php

namespace lenz\contentfield\helpers;

/**
 * Interface ReferenceMappableInterface
 */
interface ReferenceMappableInterface
{
  /**
   * Return a list of all referenced entries by this field.
   *
   * @param ReferenceMap $map
   * @return ReferenceMap
   */
  public function getReferenceMap(ReferenceMap $map = null);
}
