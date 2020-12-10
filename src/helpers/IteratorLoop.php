<?php

namespace lenz\contentfield\helpers;

use craft\helpers\ArrayHelper;
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
    $this->_count  = count($values);
    $this->_values = array_values($values);
  }

  /**
   * @param int|null|mixed $limit
   * @param string|string[]|null|mixed $only
   * @param string|string[]|null|mixed $until
   * @return IteratorLoop
   * @throws Throwable
   */
  public function getSiblings($limit = null, $only = null, $until = null) {
    $siblings = [];
    $filter = null;

    if (!is_null($limit) && !is_numeric($limit)) {
      throw new Exception('"Limit" must be an numeric value');
    }

    if (!is_null($only)) {
      if (is_callable($only)) {
        $filter = $only;
        $only = null;
      } elseif (!is_string($only) && !is_array($only)) {
        throw new Exception('"Only" must be a string, an array of strings or an arrow function');
      }
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
        (!is_null($filter) && !$filter($next)) ||
        (!is_null($only)   && !$next->getSchema()->matchesQualifier($only)) ||
        (!is_null($until)  &&  $next->getSchema()->matchesQualifier($until))
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

  /**
   * @return bool
   */
  public function hasNext() {
    return $this->_index < $this->_count - 1;
  }

  /**
   * @return bool
   */
  public function hasPrevious() {
    return $this->_index > 0;
  }

  /**
   * @return mixed
   */
  public function peakNext() {
    return $this->_index < $this->_count - 1
      ? $this->_values[$this->_index + 1]
      : null;
  }

  /**
   * @return mixed
   */
  public function peakPrevious() {
    return $this->_index > 0
      ? $this->_values[$this->_index - 1]
      : null;
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
