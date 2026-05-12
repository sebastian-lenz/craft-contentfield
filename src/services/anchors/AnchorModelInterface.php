<?php

namespace lenz\contentfield\services\anchors;

/**
 * Interface AnchorModelInterface
 */
interface AnchorModelInterface
{
  /**
   * @return AnchorInterface[]
   */
  function getAnchors(): array;
}
