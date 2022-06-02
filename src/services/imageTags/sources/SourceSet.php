<?php

namespace lenz\contentfield\services\imageTags\sources;

use ArrayIterator;
use Countable;
use craft\models\ImageTransform;
use IteratorAggregate;
use yii\base\InvalidConfigException;

/**
 * Class SourceSet
 *
 * A source set encapsulates multiple sources.
 */
class SourceSet implements Countable, IteratorAggregate
{
  /**
   * @var Source
   */
  protected Source $_nativeSource;

  /**
   * @var Source[]
   */
  protected array $_sources = [];


  /**
   * SourceSet constructor.
   *
   * @param Source $nativeSource
   * @param mixed $transforms
   */
  public function __construct(Source $nativeSource, mixed $transforms) {
    $sources = [];
    $transforms = self::normalizeTransforms($transforms);

    foreach ($transforms as $key => $transform) {
      $source = is_null($transform)
        ? $nativeSource
        : new Source($nativeSource->getAsset(), $transform);

      if (is_string($key)) {
        $source->setDescriptor($key);
      }

      $sources[] = $source;
    }

    if (empty($sources)) {
      $sources[] = $nativeSource;
    }

    $this->_nativeSource = $nativeSource;
    $this->_sources = $sources;
  }

  /**
   * @inheritDoc
   */
  public function count(): int {
    return count($this->_sources);
  }

  /**
   * @inheritDoc
   */
  public function getIterator(): ArrayIterator {
    return new ArrayIterator($this->_sources);
  }

  /**
   * @return Source
   */
  public function getMaxSource(): Source {
    return end($this->_sources);
  }

  /**
   * @return Source
   */
  public function getMinSource(): Source {
    return reset($this->_sources);
  }

  /**
   * @return string
   * @throws InvalidConfigException
   */
  public function getSrcSet(): string {
    return implode(',', array_map(function(Source $source) {
      return $source->getSrc() . ' ' . $source->getDescriptor();
    }, $this->_sources));
  }

  /**
   * @return callable[]
   */
  public function getVariables(): array {
    return array_merge(
      [
        'srcset' => [$this, 'getSrcSet'],
      ],
      $this->_nativeSource->getNativeVariables(),
      $this->getMaxSource()->getVariables(),
      $this->getMinSource()->getVariables('min')
    );
  }


  // Static methods
  // --------------

  /**
   * @param mixed $transforms
   * @return array
   */
  static public function normalizeTransforms(mixed $transforms) : array {
    if (is_array($transforms)) {
      return $transforms;
    }

    if (is_null($transforms) || $transforms instanceof ImageTransform) {
      return [$transforms];
    }

    return array_map('trim', explode(',', (string)$transforms));
  }
}
