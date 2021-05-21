<?php

namespace lenz\contentfield\helpers\loops;

/**
 * Interface LoopInterface
 *
 * https://twig.symfony.com/doc/2.x/tags/for.html#the-loop-variable
 */
interface LoopInterface
{
  /**
   * The current iteration of the loop. (1 indexed).
   *
   * @return int
   */
  public function getIndex(): int;

  /**
   * The current iteration of the loop. (0 indexed).
   *
   * @return int
   */
  public function getIndex0(): int;

  /**
   * The number of iterations from the end of the loop (1 indexed).
   *
   * @return int
   */
  public function getRevindex(): int;

  /**
   * The number of iterations from the end of the loop (0 indexed).
   *
   * @return int
   */
  public function getRevindex0(): int;

  /**
   * True if first iteration.
   *
   * @return bool
   */
  public function getFirst(): bool;

  /**
   * True if last iteration.
   *
   * @return bool
   */
  public function getLast(): bool;

  /**
   * The number of items in the sequence.
   *
   * @return int
   */
  public function getLength(): int;

  /**
   * @return bool
   */
  public function hasNext(): bool;

  /**
   * @return bool
   */
  public function hasPrevious(): bool;

  /**
   * @return mixed
   */
  public function peakNext();

  /**
   * @return mixed
   */
  public function peakPrevious();
}
