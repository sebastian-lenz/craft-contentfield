<?php

namespace lenz\contentfield\services\imageTags\sources;

use ArrayIterator;
use IteratorAggregate;
use lenz\contentfield\services\imageTags\scopes\ScopeInterface;

/**
 * Class SourceGroupSet
 *
 * A source group set encapsulates multiple source groups.
 */
class SourceGroupSet implements IteratorAggregate, ScopeInterface
{
  /**
   * @var SourceGroup[]
   */
  private array $_groups;

  /**
   * @var Source
   */
  private Source $_nativeSource;


  /**
   * SourceGroupSet constructor.
   *
   * @param Source $nativeSource
   * @param mixed|null $config
   */
  public function __construct(Source $nativeSource, mixed $config = null) {
    $this->_nativeSource = $nativeSource;
    $this->_groups = array_map(
      fn($group) => new SourceGroup($this, $group),
      is_array($config) ? $config : [$config]
    );

    if (empty($this->_groups)) {
      $this->_groups[] = new SourceGroup($this, ['transforms' => null]);
    }
  }

  /**
   * @param string $name
   * @return SourceGroup|null
   */
  public function __get(string $name): SourceGroup|null {
    return array_key_exists($name, $this->_groups)
      ? $this->_groups[$name]
      : null;
  }

  /**
   * @param string $name
   * @return boolean
   */
  public function __isset(string $name): bool {
    return array_key_exists($name, $this->_groups);
  }

  /**
   * @return SourceGroup[]
   */
  public function getGroups(): array {
    return $this->_groups;
  }

  /**
   * @return SourceSet
   * @noinspection PhpUnused
   */
  public function getMaxGroup() : SourceSet {
    return end($this->_groups);
  }

  /**
   * @return SourceSet
   * @noinspection PhpUnused
   */
  public function getMinGroup() : SourceSet {
    return reset($this->_groups);
  }

  /**
   * @inheritDoc
   */
  public function getIterator() : ArrayIterator {
    return new ArrayIterator($this->_groups);
  }

  /**
   * @inheritDoc
   */
  public function getNativeSource() : Source {
    return $this->_nativeSource;
  }

  /**
   * @inheritDoc
   */
  public function getSourceGroups() : SourceGroupSet {
    return $this;
  }

  /**
   * @inheritDoc
   */
  public function getSources() : SourceSet {
    return reset($this->_groups);
  }
}
