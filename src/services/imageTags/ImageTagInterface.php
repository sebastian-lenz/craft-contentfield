<?php

namespace lenz\contentfield\services\imageTags;

use craft\elements\Asset;

/**
 * Interface ImageTagInterface
 */
interface ImageTagInterface
{
  /**
   * ImageTagInterface constructor.
   *
   * @param Asset $asset
   * @param array $config
   */
  public function __construct(Asset $asset, array $config);

  /**
   * @return bool
   */
  public function isSupported() : bool;

  /**
   * @return string
   */
  public function render() : string;


  // Static methods
  // --------------

  /**
   * @param array $config
   * @param array $parent
   * @return array
   */
  static public function mergeConfig(array $config, array $parent) : array;
}
