<?php

namespace lenz\contentfield\behaviors;

use lenz\contentfield\models\values\ArrayValue;
use lenz\contentfield\models\values\InstanceValue;
use Throwable;
use yii\base\Behavior;

/**
 * Class InstanceSiblingsBehavior
 *
 * @property InstanceValue $owner
 */
class InstanceSiblingsBehavior extends Behavior
{
  /**
   * @return InstanceValue|null
   */
  public function getNextSibling() {
    return $this->getSibling(1);
  }

  /**
   * @return InstanceValue|null
   */
  public function getParentInstance() {
    $parent = $this->owner->getParent();
    if ($parent instanceof ArrayValue) {
      $parent = $parent->getParent();
    }

    return $parent instanceof InstanceValue
      ? $parent
      : null;
  }

  /**
   * @return InstanceValue|null
   */
  public function getPreviousSibling() {
    return $this->getSibling(-1);
  }

  /**
   * @param string|string[]|null $qualifier
   * @return boolean
   * @throws Throwable
   */
  public function hasNextSibling($qualifier = null) {
    return $this->isInstanceWithQualifier(
      $this->getSibling(1),
      $qualifier
    );
  }

  /**
   * @param string|string[]|null $qualifier
   * @return bool
   * @throws Throwable
   */
  public function hasParentInstance($qualifier = null) {
    return $this->isInstanceWithQualifier(
      $this->getParentInstance(),
      $qualifier
    );
  }

  /**
   * @param string|string[]|null $qualifier
   * @return boolean
   * @throws Throwable
   */
  public function hasPreviousSibling($qualifier = null) {
    return $this->isInstanceWithQualifier(
      $this->getSibling(-1),
      $qualifier
    );
  }


  // Private methods
  // ---------------

  /**
   * @param int $offset
   * @return InstanceValue|null
   */
  private function getSibling($offset) {
    $owner  = $this->owner;
    $parent = $owner->getParent();
    if (
      is_null($parent) ||
      !($parent instanceof ArrayValue)
    ) {
      return null;
    }

    $count = count($parent);
    for ($index = 0; $index < $count; $index++) {
      if ($parent->offsetGet($index) === $owner) {
        return $parent->offsetExists($index + $offset)
          ? $parent->offsetGet($index + $offset)
          : null;
      }
    }

    return null;
  }

  /**
   * @param mixed $value
   * @param string|string[]|null $qualifier
   * @return bool
   * @throws Throwable
   */
  private function isInstanceWithQualifier($value, $qualifier = null) {
    if (!($value instanceof InstanceValue)) {
      return false;
    }

    return is_null($qualifier)
      ? true
      : $value->getSchema()->matchesQualifier($qualifier);
  }
}
