<?php

namespace lenz\contentfield\models\enumerations;

/**
 * Interface CustomDataInterface
 */
interface CustomDataInterface
{
  /**
   * Returns the custom data with the specified name from
   * the option specified by key.
   *
   * @param int|string $key
   * @param string $name
   * @return mixed
   */
  function getCustomData(int|string $key, string $name): mixed;

  /**
   * Checks whether custom data with the specified name exists
   * for the option specified by key.
   *
   * @param int|string $key
   * @param string $name
   * @return bool
   */
  function hasCustomData(int|string $key, string $name): bool;
}
