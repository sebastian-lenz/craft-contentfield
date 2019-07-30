<?php

namespace lenz\contentfield\helpers;

use Exception;
use Iterator;
use lenz\contentfield\models\values\InstanceValue;
use Throwable;

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

  /**
   * @param int|null $limit
   * @param string|string[]|null $only
   * @param string|string[]|null $until
   * @return IteratorLoop
   * @throws Throwable
   */
  public function getSiblings($limit = null, $only = null, $until = null) {
    $siblings = [];

    if (!is_null($limit) && !is_numeric($limit)) {
      throw new Exception('"Limit" must be an numeric value');
    }

    if (!is_null($only) && !is_string($only) && !is_array($only)) {
      throw new Exception('"Only" must be a string or an array of strings');
    }

    if (!is_null($until) && !is_string($until) && !is_array($until)) {
      throw new Exception('"Until" must be a string or an array of strings');
    }

    while ($this->_index < $this->_count - 1) {
      $next = $this->_values[$this->_index + 1];
      if (!($next instanceof InstanceValue)) {
        break;
      }

      if (
        (!is_null($only)  && !$next->isOfType($only)) ||
        (!is_null($until) &&  $next->isOfType($until))
      ) {
        break;
      }

      $siblings[] = $next;
      $this->_index++;

      if (!is_null($limit) && count($siblings) >= $limit) {
        break;
      }
    }

    return new IteratorLoop($siblings);
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