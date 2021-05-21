<?php

namespace lenz\contentfield\models\migration;

use ArrayAccess;
use Countable;
use Exception;
use Throwable;

/**
 * Class Collection
 */
class Collection implements ArrayAccess, Countable
{
  /**
   * @var Instance[]
   */
  private $_instances;


  /**
   * Collection constructor.
   *
   * @param Instance[] $instances
   */
  public function __construct(array $instances = []) {
    $this->_instances = $instances;
  }

  /**
   * Append the given instance to this collection.
   *
   * @param Instance $instance
   * @return $this
   */
  public function append(Instance $instance): Collection {
    if (!in_array($instance, $this->_instances)) {
      $this->_instances[] = $instance;
    }

    return $this;
  }

  /**
   * Converts the given attribute to a html value on all instances.
   *
   * See `Instance::convertToHtml` for details.
   *
   * @param string $name
   * @param string $defaultValue
   * @return $this
   * @noinspection PhpUnused (Public API)
   */
  public function convertToHtml(string $name, string $defaultValue = ''): Collection {
    foreach ($this->_instances as $instance) {
      $instance->convertToHtml($name, $defaultValue);
    }

    return $this;
  }

  /**
   * Converts the given attribute to a string value on all instances.
   *
   * See `Instance::convertToString` for details.
   *
   * @param string $name
   * @param string $defaultValue
   * @return $this
   * @noinspection PhpUnused (Public API)
   */
  public function convertToString(string $name, string $defaultValue = ''): Collection {
    foreach ($this->_instances as $instance) {
      $instance->convertToString($name, $defaultValue);
    }

    return $this;
  }

  /**
   * Invokes the given callback on all memebrs of this
   * collection.
   *
   * @param callable $callback
   */
  public function each(callable $callback) {
    foreach ($this->_instances as $instance) {
      $callback($instance);
    }
  }

  /**
   * Makes sure the attribute with the given name is set on all
   * instances of this collection. If it is missing, it will be
   * set to the given value.
   *
   * @param string $name
   * @param mixed $value
   * @return $this
   * @noinspection PhpUnused (Public API)
   */
  public function ensureAttribute(string $name, $value): Collection {
    foreach ($this->_instances as $instance) {
      $instance->ensureAttribute($name, $value);
    }

    return $this;
  }

  /**
   * Returns a new collection containing only the instances the
   * given callback has returned `true` for.
   *
   * @param callable $callback
   * @return Collection
   * @noinspection PhpUnused (Public API)
   */
  public function filter(callable $callback): Collection {
    return new Collection(array_filter($this->_instances, $callback));
  }

  /**
   * Returns a new collection containing only the instances
   * matching the given qualifier.
   *
   * @param string|array|null $qualifier
   * @return $this
   * @throws Throwable
   * @noinspection PhpUnused (Public API)
   */
  public function matchesQualifier($qualifier): Collection {
    if (is_null($qualifier)) {
      return $this;
    }

    return new Collection(array_filter(
      $this->_instances,
      function(Instance $instance) use ($qualifier) {
        return $instance->matchesQualifier($qualifier);
      }
    ));
  }

  /**
   * Appends all members of the given collection to this
   * collection.
   *
   * @param Collection $collection
   * @return $this
   */
  public function merge(Collection $collection): Collection {
    foreach ($collection->_instances as $instance) {
      $this->append($instance);
    }

    return $this;
  }

  /**
   * Modifies the attribute with the given name by using the given
   * callback function on all instances in this collection.
   *
   * @param string $name
   * @param callable $callback
   * @return $this
   * @noinspection PhpUnused (Public API)
   */
  public function modifyAttribute(string $name, callable $callback): Collection {
    foreach ($this->_instances as $instance) {
      $instance->modifyAttribute($name, $callback);
    }

    return $this;
  }

  /**
   * Rename the attribute with the given old name to the new name
   * on all instances in this collection.
   *
   * @param array $replacements
   * @return $this
   * @noinspection PhpUnused (Public API)
   */
  public function renameAttribute(array $replacements): Collection {
    foreach ($this->_instances as $instance) {
      $instance->renameAttribute($replacements);
    }

    return $this;
  }

  /**
   * Renames the type of all instances in this collection using
   * the given replacement map.
   *
   * @param array $replacements
   * @return $this
   * @throws Exception
   */
  public function renameType(array $replacements): Collection {
    foreach ($this->_instances as $instance) {
      $instance->renameType($replacements);
    }

    return $this;
  }

  /**
   * Remove the attribute with the given name from all instances
   * in this collection.
   *
   * @param string $name
   * @return $this
   */
  public function removeAttribute(string $name): Collection {
    foreach ($this->_instances as $instance) {
      $instance->removeAttribute($name);
    }

    return $this;
  }

  /**
   * Sets an attribute on all instances in this collection.
   *
   * @param string $name
   * @param mixed $value
   * @return $this
   */
  public function setAttribute(string $name, $value): Collection {
    foreach ($this->_instances as $instance) {
      $instance->setAttribute($name, $value);
    }

    return $this;
  }

  /**
   * Sets multiple attributes on all instances in this collection.
   *
   * @param array $attributes
   * @return $this
   */
  public function setAttributes(array $attributes): Collection {
    foreach ($this->_instances as $instance) {
      $instance->setAttributes($attributes);
    }

    return $this;
  }

  /**
   * Set the type of all instances in this collection.
   *
   * @param string $qualifier
   * @return $this
   * @throws Exception
   */
  public function setType(string $qualifier): Collection {
    foreach ($this->_instances as $instance) {
      $instance->setType($qualifier);
    }

    return $this;
  }

  /**
   * Return all instances of this collection as an array.
   *
   * @return Instance[]
   */
  public function toArray(): array {
    return $this->_instances;
  }


  // ArrayAccess
  // -----------

  /**
   * @inheritDoc
   */
  public function offsetExists($offset): bool {
    return array_key_exists($offset, $this->_instances);
  }

  /**
   * @inheritDoc
   */
  public function offsetGet($offset) {
    return $this->_instances[$offset];
  }

  /**
   * @inheritDoc
   */
  public function offsetSet($offset, $value) {
    $this->_instances[$offset] = $value;
  }

  /**
   * @inheritDoc
   */
  public function offsetUnset($offset) {
    unset($this->_instances[$offset]);
  }


  // Countable
  // -----------

  /**
   * @inheritDoc
   */
  public function count(): int {
    return count($this->_instances);
  }
}
