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
   * @param string|int $key
   * @param string $name
   * @return mixed
   */
  function getCustomData($key, string $name);

  /**
   * Checks whether custom data with the specified name exists
   * for the option specified by key.
   *
   * @param string|int $key
   * @param string $name
   * @return bool
   */
  function hasCustomData($key, string $name): bool;
}
