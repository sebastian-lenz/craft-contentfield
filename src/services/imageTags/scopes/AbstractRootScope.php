<?php

namespace lenz\contentfield\services\imageTags\scopes;

use craft\elements\Asset;
use lenz\contentfield\services\imageTags\sources\Source;
use lenz\contentfield\services\imageTags\sources\SourceGroupSet;
use lenz\contentfield\services\imageTags\sources\SourceSet;

/**
 * Class AbstractRootScope
 */
abstract class AbstractRootScope implements ScopeInterface
{
  /**
   * @var Source
   */
  protected $_nativeSource;

  /**
   * @var SourceSet
   */
  private $_sources;


  /**
   * AbstractRootScope constructor.
   *
   * @param Asset $asset
   */
  public function __construct(Asset $asset) {
    $this->_nativeSource = new Source($asset);
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
  public function getSourceGroups(): SourceGroupSet {
    return new SourceGroupSet($this->_nativeSource);
  }

  /**
   * @inheritDoc
   */
  public function getSources() : SourceSet {
    if (!isset($this->_sources)) {
      $this->_sources = new SourceSet($this->_nativeSource, [null]);
    }

    return $this->_sources;
  }
}
