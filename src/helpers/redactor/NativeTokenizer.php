<?php

namespace lenz\contentfield\helpers\redactor;

use Craft;

/**
 * class NativeTokenizer
 */
class NativeTokenizer extends AbstractTokenizer
{
  /**
   * @return string
   */
  protected function compile(): string {
    return Craft::$app->getElements()->parseRefs($this->_rawContent);
  }
}
