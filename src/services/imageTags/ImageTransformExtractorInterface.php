<?php

namespace lenz\contentfield\services\imageTags;

/**
 * Interface ImageTransformExtractorInterface
 */
interface ImageTransformExtractorInterface
{
  /**
   * @param array $config
   * @return array
   */
  static public function extractTransforms(array $config) : array;
}
