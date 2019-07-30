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


  // Static methods
  // --------------

  /**
   * @return StaticLoop
   */
  static function getInstance() {
    if (!isset(self::$_instance)) {
      self::$_instance = new StaticLoop();
    }

    return self::$_instance;
  }
}
