<?php

namespace lenz\contentfield\services\imageTags\helpers;

/**
 * Class WrappedCallback
 */
class WrappedCallback
{
  /**
   * @var callable
   */
  private $_callback;


  /**
   * WrappedCallback constructor.
   *
   * @param callable $callback
   */
  public function __construct(callable $callback) {
    $this->_callback = $callback;
  }

  /**
   * @return mixed
   */
  public function __toString() {
    $callback = $this->_callback;
    return (string)$callback();
  }
}
