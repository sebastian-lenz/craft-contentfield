<?php

namespace lenz\contentfield\helpers;

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
  public function getIndex();

  /**
   * The current iteration of the loop. (0 indexed).
   *
   * @return int
   */
  public function getIndex0();

  /**
   * The number of iterations from the end of the loop (1 indexed).
   *
   * @return int
   */
  public function getRevindex();

  /**
   * The number of iterations from the end of the loop (0 indexed).
   *
   * @return int
   */
  public function getRevindex0();

  /**
   * True if first iteration.
   *
   * @return bool
   */
  public function getFirst();

  /**
   * True if last iteration.
   *
   * @return bool
   */
  public function getLast();

  /**
   * The number of items in the sequence.
   *
   * @return int
   */
  public function getLength();

  /**
   * @return bool
   */
  public function hasNext();

  /**
   * @return bool
   */
  public function hasPrevious();

  /**
   * @return mixed
   */
  public function peakNext();

  /**
   * @return mixed
   */
  public function peakPrevious();
}
