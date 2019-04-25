<?php

namespace lenz\contentfield\models\enumerations;

/**
 * Interface EnumerationInterface
 */
interface EnumerationInterface
{
  /**
   * @param string|int $key
   * @param string $name
   * @return mixed
   */
  function getCustomData($key, $name);

  /**
   * Return an array of all options.
   * @return array
   */
  function getOptions();
}
