<?php

namespace lenz\contentfield\helpers\loops;

use Exception;
use Iterator;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\twig\DisplayInterface;
use Throwable;

/**
 * Class IteratorLoop
 */
class IteratorLoop implements DisplayInterface, Iterator, LoopInterface
{
  /**
   * @phpstan-var int
   */
  private int $_count;

  /**
   * @phpstan-var int
   */
  private int $_index = 0;

  /**
   * @phpstan-var array
   */
  private array $_values;


  /**
   * LoopIterator constructor.
   * @phpstan-param array $values
   */
  public function __construct(array $values) {
    $this->_count  = count($values);
    $this->_values = array_values($values);
  }

  /**
   * @phpstan-param array $variables
   * @phpstan-param callable|null $callback
   * @phpstan-return void
   * @throws Exception
   */
  public function display(array $variables = []): void {
    $variables['loop'] = $this;

    foreach ($this as $value) {
      if ($value instanceof InstanceValue) {
        $value->display($variables);
      } else {
        echo $value;
      }
    }
  }

  /**
   * @phpstan-param mixed|null $limit
   * @phpstan-param mixed|null $only
   * @phpstan-param mixed|null $until
   * @phpstan-param bool|null $addBack
   * @phpstan-return IteratorLoop
   * @throws Throwable
   * @noinspection PhpUnused
   */
  public function getSiblings(mixed $limit = null, mixed $only = null, mixed $until = null, bool $addBack = null): IteratorLoop {
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

    if ($addBack === true) {
      $siblings[] = $this->current();
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
  public function getIndex(): int {
    return $this->_index + 1;
  }

  /**
   * @inheritDoc
   */
  public function getIndex0(): int {
    return $this->_index;
  }

  /**
   * @inheritDoc
   */
  public function getRevindex(): int {
    return $this->_count - $this->_index;
  }

  /**
   * @inheritDoc
   */
  public function getRevindex0(): int {
    return $this->_count - $this->_index - 1;
  }

  /**
   * @inheritDoc
   */
  public function getFirst(): bool {
    return $this->_index == 0;
  }

  /**
   * @inheritDoc
   */
  public function getLast(): bool {
    return $this->_index == $this->_count - 1;
  }

  /**
   * @inheritDoc
   */
  public function getLength(): int {
    return $this->_count;
  }

  /**
   * @phpstan-return bool
   */
  public function hasNext(): bool {
    return $this->_index < $this->_count - 1;
  }

  /**
   * @phpstan-return bool
   */
  public function hasPrevious(): bool {
    return $this->_index > 0;
  }

  /**
   * @phpstan-return mixed
   */
  public function peakNext(): mixed {
    return $this->_index < $this->_count - 1
      ? $this->_values[$this->_index + 1]
      : null;
  }

  /**
   * @phpstan-return mixed
   */
  public function peakPrevious(): mixed {
    return $this->_index > 0
      ? $this->_values[$this->_index - 1]
      : null;
  }


  // Iterator implementation
  // -----------------------

  /**
   * @inheritDoc
   */
  public function current(): mixed {
    return $this->_values[$this->_index];
  }

  /**
   * @inheritDoc
   */
  public function next(): void {
    $this->_index += 1;
  }

  /**
   * @inheritDoc
   */
  public function key(): mixed {
    return $this->_index;
  }

  /**
   * @inheritDoc
   */
  public function valid(): bool {
    return $this->_index >= 0 && $this->_index < $this->_count;
  }

  /**
   * @inheritDoc
   */
  public function rewind(): void {
    $this->_index = 0;
  }
}
