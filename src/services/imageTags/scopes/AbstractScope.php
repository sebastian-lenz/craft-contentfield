<?php

namespace lenz\contentfield\services\imageTags\scopes;

use lenz\contentfield\services\imageTags\sources\Source;
use lenz\contentfield\services\imageTags\sources\SourceGroupSet;
use lenz\contentfield\services\imageTags\sources\SourceSet;
use yii\base\BaseObject;

/**
 * Class AbstractScope
 */
abstract class AbstractScope extends BaseObject implements ScopeInterface
{
  /**
   * @var mixed
   */
  public $transforms = null;

  /**
   * @var mixed
   */
  public $transformGroups = null;

  /**
   * @var Source|null
   */
  private $_nativeSource = null;

  /**
   * @var ScopeInterface
   */
  private $_parent;

  /**
   * @var SourceGroupSet
   */
  private $_sourceGroups;

  /**
   * @var SourceSet
   */
  private $_sources;


  /**
   * AbstractScope constructor.
   *
   * @param ScopeInterface $parent
   * @param array $config
   */
  public function __construct(ScopeInterface $parent, array $config) {
    parent::__construct($config);
    $this->_parent = $parent;
  }

  /**
   * @return Source
   */
  public function getNativeSource() : Source {
    if (is_null($this->_nativeSource)) {
      return $this->_parent->getNativeSource();
    }

    return $this->_nativeSource;
  }

  /**
   * @inheritDoc
   */
  public function getSourceGroups(): SourceGroupSet {
    if (is_null($this->transformGroups)) {
      return $this->_parent->getSourceGroups();
    }

    if (!isset($this->_sourceGroups)) {
      $this->_sourceGroups = new SourceGroupSet($this->getNativeSource(), $this->transformGroups);
    }

    return $this->_sourceGroups;
  }

  /**
   * @return SourceSet
   */
  public function getSources() : SourceSet {
    if (is_null($this->transforms)) {
      return $this->_parent->getSources();
    }

    if (!isset($this->_sources)) {
      $this->_sources = new SourceSet($this->getNativeSource(), $this->transforms);
    }

    return $this->_sources;
  }


  // Static methods
  // --------------

  /**
   * Expand the given attribute array by injecting the given variables.
   *
   * - Replaces both Craft::t style variables like `{width}` als well as
   *   PHP style variables like `{$width}` within strings.
   * - Replaces attribute values starting with `$` as this is is easier
   *   to use in yaml definitions.
   * - Multiple fields can be given seperated by a pipe `|`, the first 
   *   non empty attribute value will be used
   *
   * @param callable[] $variables
   * @param array $attributes
   * @return array
   */
  static public function expandAttributes(array $variables, array $attributes) : array {
    $result = [];
    $replace = function($match) use ($variables) {
      $names = explode('|', $match[1]);
      $isEmpty = false;
      foreach ($names as $name) {
        $name = trim($name);
        if (!array_key_exists($name, $variables)) {
          continue;
        }

        $result = $variables[$name]();
        if (!empty($result)) {
          return $result;
        } else {
          $isEmpty = true;
        }
      }

      return $isEmpty ? '' : $match[0];
    };

    foreach ($attributes as $key => $value) {
      if (strlen($value) > 0 && substr($value, 0, 1) == '$') {
        $value = $replace([$value, substr($value, 1)]);
      }

      $value = preg_replace_callback('/\{\s*\$?([^}\s]*)\s*\}/u', $replace, $value);
      if (!empty($value)) {
        $result[$key] = $value;
      }
    }

    return $result;
  }
}
