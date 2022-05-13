<?php

namespace lenz\contentfield\helpers\loops;

/**
 * Class StaticLoop
 */
class StaticLoop implements LoopInterface
{
  /**
   * @var StaticLoop
   */
  private static StaticLoop $_instance;


  /**
   * @inheritDoc
   */
  public function getIndex(): int {
    return 1;
  }

  /**
   * @inheritDoc
   */
  public function getIndex0(): int {
    return 0;
  }

  /**
   * @inheritDoc
   */
  public function getRevindex(): int {
    return 1;
  }

  /**
   * @inheritDoc
   */
  public function getRevindex0(): int {
    return 0;
  }

  /**
   * @inheritDoc
   */
  public function getFirst(): bool {
    return true;
  }

  /**
   * @inheritDoc
   */
  public function getLast(): bool {
    return true;
  }

  /**
   * @inheritDoc
   */
  public function getLength(): int {
    return 1;
  }

  /**
   * @return bool
   */
  public function hasNext(): bool {
    return false;
  }

  /**
   * @return bool
   */
  public function hasPrevious(): bool {
    return false;
  }

  /**
   * @return mixed
   */
  public function peakNext(): mixed {
    return null;
  }

  /**
   * @return mixed
   */
  public function peakPrevious(): mixed {
    return null;
  }


  // Static methods
  // --------------

  /**
   * @return StaticLoop
   */
  static public function getInstance(): StaticLoop {
    if (!isset(self::$_instance)) {
      self::$_instance = new StaticLoop();
    }

    return self::$_instance;
  }
}
