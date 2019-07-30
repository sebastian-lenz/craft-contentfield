<?php

namespace lenz\contentfield\helpers;

use Iterator;

/**
 * Class IteratorLoop
 */
class IteratorLoop implements Iterator, LoopInterface
{
  /**
   * @var int
   */
  private $_count;

  /**
   * @var int
   */
  private $_index = 0;

  /**
   * @var array
   */
  private $_values;


  /**
   * LoopIterator constructor.
   * @param array $values
   */
  public function __construct(array $values) {
    $this->_count = count($values);
    $this->_values = $values;
  }


  // Loop implementation
  // -------------------

  /**
   * @inheritDoc
   */
  public function getIndex() {
    return $this->_index + 1;
  }

  /**
   * @inheritDoc
   */
  public function getIndex0() {
    return $this->_index;
  }

  /**
   * @inheritDoc
   */
  public function getRevindex() {
    return $this->_count - $this->_index;
  }

  /**
   * @inheritDoc
   */
  public function getRevindex0() {
    return $this->_count - $this->_index - 1;
  }

  /**
   * @inheritDoc
   */
  public function getFirst() {
    return $this->_index == 0;
  }

  /**
   * @inheritDoc
   */
  public function getLast() {
    return $this->_index == $this->_count - 1;
  }

  /**
   * @inheritDoc
   */
  public function getLength() {
    return $this->_count;
  }


  // Iterator implementation
  // -----------------------

  /**
   * @inheritDoc
   */
  public function current() {
    return $this->_values[$this->_index];
  }

  /**
   * @inheritDoc
   */
  public function next() {
    $this->_index += 1;
  }

  /**
   * @inheritDoc
   */
  public function key() {
    return $this->_index;
  }

  /**
   * @inheritDoc
   */
  public function valid() {
    return $this->_index >= 0 && $this->_index < $this->_count;
  }

  /**
   * @inheritDoc
   */
  public function rewind() {
    $this->_index = 0;
  }
}
