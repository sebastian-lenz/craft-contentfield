<?php

namespace lenz\contentfield\services\imageTags;

use craft\elements\Asset;
use craft\helpers\Image;
use Exception;
use lenz\contentfield\services\imageTags\nodes\TagNode;
use lenz\contentfield\services\imageTags\scopes\AbstractRootScope;
use lenz\contentfield\services\imageTags\sources\SourceSet;

/**
 * Class ConfigImageTag
 *
 * An image tag whose output is determined by a configuration structure.
 */
class ConfigImageTag extends AbstractRootScope implements ImageTagInterface, ImageTransformExtractorInterface
{
  /**
   * @var TagNode
   */
  private $_rootNode;

  /**
   * A list of all attributes that might contain transforms
   */
  const TRANSFORM_ATTRIBUTES = ['transform', 'transforms'];


  /**
   * ConfigImageTag constructor.
   *
   * @param Asset $asset
   * @param array $config
   * @throws Exception
   */
  public function __construct(Asset $asset, array $config) {
    parent::__construct($asset);
    $this->_rootNode = new TagNode($this, self::expandConfigRecursive($config));
  }

  /**
   * @inheritDoc
   */
  public function isSupported(): bool {
    $ext = $this->_nativeSource->getAsset()->getExtension();
    return Image::canManipulateAsImage($ext);
  }

  /**
   * @inheritDoc
   */
  public function render(): string {
    return $this->_rootNode->render();
  }


  // Static methods
  // --------------

  /**
   * @inheritDoc
   */
  static public function extractTransforms(array $config): array {
    $result = [];

    foreach ($config as $key => $value) {
      if (in_array($key, self::TRANSFORM_ATTRIBUTES)) {
        $result = array_merge($result, SourceSet::normalizeTransforms($value));
      } else if (is_array($value)) {
        $result = array_merge($result, self::extractTransforms($value));
      }
    }

    return $result;
  }

  /**
   * @inheritDoc
   */
  static public function mergeConfig(array $config, array $parent) : array {
    self::expandConfigRecursive($config);
    self::expandConfigRecursive($parent);

    return self::mergeTags($config, $parent);
  }


  // Static private methods
  // ----------------------

  /**
   * Merges two tag arrays.
   *
   * @param array $config
   * @param array $parent
   * @return array
   */
  static private function mergeTags(array $config, array $parent) : array {
    foreach ($config as $key => $value) {
      if ($key == 'attributes' && isset($parent[$key])) {
        $parent[$key] = self::mergeTagAttributes($value, $parent[$key]);
      } elseif ($key == 'children' && isset($parent[$key])) {
        $parent[$key] = self::mergeTagChildren($value, $parent[$key]);
      } else {
        $parent[$key] = $value;
      }
    }

    return $parent;
  }

  /**
   * Merges two attribute arrays.
   *
   * Merging is handled by `array_merge`, with an additional check for the
   * attribute `class` which allows appending values
   *
   * @param array $config
   * @param array $parent
   * @param string $key
   * @return array
   */
  static public function mergeTagAttributes($config, $parent, $key = 'class') {
    $config = is_array($config) ? $config : [];
    $parent = is_array($parent) ? $parent : [];

    if (
      array_key_exists($key, $config) &&
      array_key_exists($key, $parent)
    ) {
      if ($config[$key]{0} == '+') {
        $config[$key] = implode(' ', array_unique(array_merge(
          explode(' ', $parent[$key]),
          explode(' ', substr($config[$key], 1))
        )));
      }
    }

    return array_merge($parent, $config);
  }

  /**
   * Merges two children arrays.
   *
   * Calls `mergeTags` recursively if needed.
   *
   * @param array|mixed $config
   * @param array|mixed $parent
   * @return array
   */
  static private function mergeTagChildren($config, $parent) : array {
    $config = is_array($config) ? $config : [];
    $parent = is_array($parent) ? $parent : [];

    foreach ($config as $key => $value) {
      if (is_int($key)) {
        if (array_key_exists($key, $parent)) {
          $parent[] = $value;
        } else {
          $parent[$key] = $value;
        }
      } elseif (
        isset($parent[$key]) &&
        is_array($parent[$key]) &&
        is_array($value)
      ) {
        $parent[$key] = static::mergeTags($parent[$key], $value);
      } else {
        $parent[$key] = $value;
      }
    }

    return $parent;
  }

  /**
   * Expand the given config array.
   *
   * Used to evaluate the shortcuts `.` and `+`:
   * - Keys starting with `.` are moved to the `attributes` option.
   * - Keys starting with `+` are moved to the `children` option.
   *
   * @param array $config
   * @return array
   */
  static private function expandConfig(array &$config) {
    AbstractImageTag::expandConfig($config);

    foreach ($config as $key => &$value) {
      if ($key{0} == '.') {
        $appendTo = 'attributes';
      } elseif ($key{0} == '+') {
        $appendTo = 'children';
      } else {
        continue;
      }

      if (
        isset($config[$appendTo]) &&
        !is_array($config[$appendTo]))
      {
        $config[$appendTo] = [$config[$appendTo]];
      }

      unset($config[$key]);
      $config[$appendTo][substr($key, 1)] = $value;
    }

    return $config;
  }

  /**
   * Recursive config array expansion.
   *
   * Makes sure nested `children` and `transformGroups` are expanded
   * as well.
   *
   * @param array $config
   * @return array
   */
  static private function expandConfigRecursive(array &$config) {
    self::expandConfig($config);

    if (
      !array_key_exists('children', $config) ||
      !is_array($config['children'])
    ) {
      return $config;
    }

    foreach ($config['children'] as &$value) {
      if (is_array($value)) {
        self::expandConfigRecursive($value);
      }
    }

    return $config;
  }
}
