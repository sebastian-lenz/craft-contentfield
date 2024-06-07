<?php

namespace lenz\contentfield\models\values;

use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\fields\HotspotField;
use lenz\contentfield\models\values\HotspotValue\Shape;

/**
 * Class HotspotValue
 *
 * @property HotspotField $_field
 */
class HotspotValue extends AbstractValue implements \Countable, \JsonSerializable
{
  /**
   * @var HotspotValue\Shape[]
   */
  public array $shapes = [];


  /**
   * @param $data
   * @param ValueInterface|null $parent
   * @param AbstractField|null $field
   */
  public function __construct($data, ValueInterface $parent = null, AbstractField $field = null) {
    parent::__construct($parent, $field);

    if (is_array($data)) {
      foreach ($data as $shape) {
        $this->tryAddShape($shape);
      }
    } else {
      $this->tryAddShape($data);
    }
  }

  /**
   * @inheritDoc
   */
  function __toString() {
    return '';
  }

  /**
   * @return int
   */
  public function count(): int {
    return count($this->shapes);
  }

  /**
   * @inheritDoc
   */
  function isEmpty(): bool {
    return true;
  }

  /**
   * @inheritDoc
   */
  public function jsonSerialize(): array {
    return $this->shapes;
  }


  // Private methods
  // ---------------

  /**
   * @param mixed $data
   * @return void
   */
  private function tryAddShape(mixed $data): void {
    $shape = is_array($data) ? Shape::tryCreate($data) : null;
    if ($shape) {
      $this->shapes[] = $shape;
    }
  }
}
