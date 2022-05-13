<?php

namespace lenz\contentfield\services\imageTags\sources;

use lenz\contentfield\services\imageTags\ConfigImageTag;
use lenz\contentfield\services\imageTags\scopes\ScopeInterface;

/**
 * Class SourceGroup
 *
 * A source group is an extended source set. It is tied to a source group
 * set end exposes a separate rendering scope.
 */
class SourceGroup extends SourceSet implements ScopeInterface
{
  /**
   * @var array
   */
  public array $attributes = [];

  /**
   * @var SourceGroupSet
   */
  private SourceGroupSet $_parent;


  /**
   * SourceGroup constructor.
   *
   * @param SourceGroupSet $parent
   * @param mixed $config
   */
  public function __construct(SourceGroupSet $parent, mixed $config) {
    $transforms = [];
    $this->_parent = $parent;

    if (!is_array($config)) {
      $transforms = $config;
    } else {
      foreach ($config as $key => $value) {
        if (in_array($key, ConfigImageTag::TRANSFORM_ATTRIBUTES)) {
          $transforms = array_merge(
            $transforms,
            SourceSet::normalizeTransforms($value)
          );
        } else {
          $this->setAttribute($key, $value);
        }
      }
    }

    parent::__construct($parent->getNativeSource(), $transforms);
  }

  /**
   * @param string $name
   * @return mixed
   */
  public function __get(string $name): mixed {
    return array_key_exists($name, $this->attributes)
      ? $this->attributes[$name]
      : null;
  }

  /**
   * @param string $name
   * @return boolean
   */
  public function __isset(string $name) {
    return array_key_exists($name, $this->attributes);
  }

  /**
   * @inheritDoc
   */
  public function getNativeSource(): Source {
    return $this->_nativeSource;
  }

  /**
   * @inheritDoc
   */
  public function getSourceGroups(): SourceGroupSet {
    return $this->_parent;
  }

  /**
   * @inheritDoc
   */
  public function getSources(): SourceSet {
    return $this;
  }


  // Protected methods
  // -----------------

  /**
   * @param string $name
   * @param mixed $value
   */
  protected function setAttribute(string $name, mixed $value) {
    if (str_starts_with($name, '.')) {
      $name = substr($name, 1);
    }

    $this->attributes[$name] = $value;
  }
}
