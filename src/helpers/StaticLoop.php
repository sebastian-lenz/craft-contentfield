<?php

namespace lenz\contentfield\helpers;

/**
 * Class StaticLoop
 */
class StaticLoop implements LoopInterface
{
  /**
   * @var StaticLoop
   */
  private static $_instance;


  /**
   * @inheritDoc
   */
  public function getIndex() {
    return 1;
  }

  /**
   * @inheritDoc
   */
  public function getIndex0() {
    return 0;
  }

  /**
   * @inheritDoc
   */
  public function getRevindex() {
    return 1;
  }

  /**
   * @inheritDoc
   */
  public function getRevindex0() {
    return 0;
  }

  /**
   * @inheritDoc
   */
  public function getFirst() {
    return true;
  }

  /**
   * @inheritDoc
   */
  public function getLast() {
    return true;
  }

  /**
   * @inheritDoc
   */
  public function getLength() {
    return 1;
  }

  /**
   * @return bool
   */
  public function hasNext() {
    return false;
  }

  /**
   * @return bool
   */
  public function hasPrevious() {
    return false;
  }

  /**
   * @return mixed
   */
  public function peakNext() {
    return null;
  }

  /**
   * @return mixed
   */
  public function peakPrevious() {
    return null;
  }


  // Static methods
  // --------------

  /**
   * @return StaticLoop
   */
  static public function getInstance() {
    if (!isset(self::$_instance)) {
      self::$_instance = new StaticLoop();
    }

    return self::$_instance;
  }
}
