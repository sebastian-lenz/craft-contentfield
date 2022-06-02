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
class SiblingsBehavior extends Behavior
{
  /**
   * @return InstanceValue|null
   * @noinspection PhpUnused (Public API)
   */
  public function getNextSibling(): ?InstanceValue {
    return $this->getSibling(1);
  }

  /**
   * @return InstanceValue|null
   */
  public function getParentInstance(): ?InstanceValue {
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
   * @noinspection PhpUnused (Public API)
   */
  public function getPreviousSibling(): ?InstanceValue {
    return $this->getSibling(-1);
  }

  /**
   * @param string|string[]|null $qualifier
   * @return boolean
   * @throws Throwable
   * @noinspection PhpUnused (Public API)
   */
  public function hasNextSibling(array|string $qualifier = null): bool {
    return $this->isInstanceWithQualifier(
      $this->getSibling(1),
      $qualifier
    );
  }

  /**
   * @param string|string[]|null $qualifier
   * @return bool
   * @throws Throwable
   * @noinspection PhpUnused (Public API)
   */
  public function hasParentInstance(array|string $qualifier = null): bool {
    return $this->isInstanceWithQualifier(
      $this->getParentInstance(),
      $qualifier
    );
  }

  /**
   * @param string|string[]|null $qualifier
   * @return boolean
   * @throws Throwable
   * @noinspection PhpUnused (Public API)
   */
  public function hasPreviousSibling(array|string $qualifier = null): bool {
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
  private function getSibling(int $offset): ?InstanceValue {
    $owner = $this->owner;
    $parent = $owner->getParent();
    if (!($parent instanceof ArrayValue)) {
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
  private function isInstanceWithQualifier(mixed $value, array|string $qualifier = null): bool {
    if (!($value instanceof InstanceValue)) {
      return false;
    }

    return is_null($qualifier) || $value->getSchema()->matchesQualifier($qualifier);
  }
}
