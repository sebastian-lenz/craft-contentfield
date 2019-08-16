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
  private $_groups;

  /**
   * @var Source
   */
  private $_nativeSource;


  /**
   * SourceGroupSet constructor.
   *
   * @param Source $nativeSource
   * @param mixed $config
   */
  public function __construct(Source $nativeSource, $config = null) {
    $this->_nativeSource = $nativeSource;

    if (!is_array($config)) {
      $config = [$config];
    }

    $this->_groups = array_map(function($group) {
      return new SourceGroup($this, $group);
    }, $config);

    if (empty($this->_groups)) {
      $this->_groups[] = new SourceGroup($this, ['transforms' => null]);
    }
  }

  /**
   * @param $name
   * @return SourceGroup|null
   */
  public function __get($name) {
    return array_key_exists($name, $this->_groups)
      ? $this->_groups[$name]
      : null;
  }

  /**
   * @param string $name
   * @return boolean
   */
  public function __isset($name) {
    return array_key_exists($name, $this->_groups);
  }

  /**
   * @return SourceGroup[]
   */
  public function getGroups() {
    return $this->_groups;
  }

  /**
   * @return SourceSet
   */
  public function getMaxGroup() : SourceSet {
    return end($this->_groups);
  }

  /**
   * @return SourceSet
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
