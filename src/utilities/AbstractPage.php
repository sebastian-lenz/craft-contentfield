<?php

namespace lenz\contentfield\utilities;

use Throwable;

/**
 * Class AbstractPage
 */
abstract class AbstractPage
{
  /**
   * @return string
   * @throws Throwable
   */
  abstract public function contentHtml() : string;

  /**
   * @return string
   */
  abstract public function getHandle() : string;

  /**
   * @return string
   */
  abstract public function getIcon() : string;

  /**
   * @return string
   */
  abstract public function getLabel() : string;

  /**
   * @return string
   */
  public function getUrl(): string {
    return '/admin/utilities/tcf-utilities?tab=' . $this->getHandle();
  }
}
