<?php

namespace lenz\contentfield\services\imageTags\scopes;

use lenz\contentfield\services\imageTags\sources\Source;
use lenz\contentfield\services\imageTags\sources\SourceGroupSet;
use lenz\contentfield\services\imageTags\sources\SourceSet;

/**
 * Interface ScopeInterface
 */
interface ScopeInterface
{
  /**
   * @return Source
   */
  public function getNativeSource(): Source;

  /**
   * @return SourceGroupSet
   */
  public function getSourceGroups(): SourceGroupSet;

  /**
   * @return SourceSet
   */
  public function getSources(): SourceSet;
}
