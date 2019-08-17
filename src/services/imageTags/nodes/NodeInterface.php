<?php

namespace lenz\contentfield\services\imageTags\nodes;

use lenz\contentfield\services\imageTags\scopes\ScopeInterface;

/**
 * Interface NodeInterface
 */
interface NodeInterface
{
  /**
   * @param ScopeInterface|null $scope
   * @return string
   */
  public function render(ScopeInterface $scope = null) : string;
}
