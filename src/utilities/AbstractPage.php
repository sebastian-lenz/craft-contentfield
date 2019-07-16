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
  abstract public function contentHtml();

  /**
   * @return string
   */
  abstract public function getHandle();

  /**
   * @return string
   */
  abstract public function getLabel();

  /**
   * @return array
   */
  public function getTab() {
    return [
      'label' => $this->getLabel(),
      'url'   => $this->getUrl(),
    ];
  }

  /**
   * @return string
   */
  public function getUrl() {
    return '/admin/utilities/tcf-utilities?tab=' . $this->getHandle();
  }
}
