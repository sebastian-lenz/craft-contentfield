<?php

namespace lenz\contentfield\helpers\debug;

use Craft;
use craft\base\Element;
use craft\base\Model;
use craft\elements\db\AssetQuery;
use craft\elements\db\ElementQuery;
use craft\elements\db\EntryQuery;
use Twig\Template;

/**
 * Class QueryInfo
 */
class QueryInfo extends Model
{
  /**
   * @var array
   */
  public $backtrace = [];

  /**
   * @var array
   */
  public $criteria;

  /**
   * @var int
   */
  public $index;

  /**
   * @var string
   */
  public $queryClass;

  /**
   * @var array
   */
  public $templates = [];

  /**
   * @var string
   */
  public $type = self::TYPE_COMMON;

  /**
   * @var ElementQuery
   */
  private $_query;

  /**
   * @var int
   */
  static private $_index = 0;

  /**
   * Known query types.
   */
  const TYPE_ASSET = 'asset';
  const TYPE_COMMON = 'common';
  const TYPE_ENTRY = 'entry';


  /**
   * @return void
   */
  public function beforeSave() {
    if (!isset($this->_query)) {
      return;
    }

    $query = $this->_query;
    unset($this->_query);

    $this->criteria = array_map(
      [__CLASS__, 'removeEntries'],
      array_filter($query->getCriteria())
    );
  }

  /**
   * @param ElementQuery $query
   */
  public function setQuery(ElementQuery $query) {
    if ($query instanceof EntryQuery) {
      $this->type = self::TYPE_ENTRY;
    } elseif ($query instanceof AssetQuery) {
      $this->type = self::TYPE_ASSET;
    }

    $this->_query = $query;
    $this->queryClass = get_class($query);
    $this->index = self::$_index++;

    $this->fetchBacktrace();
  }


  // Private methods
  // ---------------

  /**
   * @param array $data
   * @param bool $isExternal
   */
  private function addBacktrace(array $data, bool $isExternal) {
    if (isset($data['object']) && $data['object'] instanceof Template) {
      $template = $data['object']->getSourceContext()->getName();
      $this->addTemplate($data, $template);
    }
    elseif (isset($data['class'])) {
      $this->backtrace[] = [
        'type' => 'class',
        'name' => $data['class'],
        'function' => $data['function'],
        'external' => $isExternal,
        'line' => $data['line'],
      ];
    }
  }

  /**
   * @param array $data
   * @param string $name
   */
  private function addTemplate(array $data, string $name) {
    if (!in_array($name, $this->templates)) {
      $this->templates[] = $name;
    }

    if (count($this->backtrace)) {
      $last = end($this->backtrace);
      if ($last['type'] == 'template' && $last['name'] == $name) {
        return;
      }
    }

    $this->backtrace[] = [
      'type' => 'template',
      'name' => $name,
      'external' => false,
      'line' => $data['line'],
    ];
  }

  /**
   * @return void
   */
  private function fetchBacktrace() {
    $backtrace = debug_backtrace();
    $root      = Craft::getAlias('@root');
    $vendor    = Craft::getAlias('@vendor');

    $count = count($backtrace) - 1;
    for ($index = 11; $index < $count; $index++) {
      $data = $backtrace[$index];
      if (!isset($data['file'])) {
        continue;
      }

      $isExternal = (
        substr($data['file'], 0, strlen($root)) != $root ||
        substr($data['file'], 0, strlen($vendor)) == $vendor
      );

      $this->addBacktrace($data, $isExternal);
    }
  }

  /**
   * @param array $value
   * @return mixed
   */
  static public function removeEntries($value) {
    if ($value instanceof Element) {
      return 'Element ( ' . (string)$value . ', ' . $value->id . ' )';
    } else if (is_array($value)) {
      return array_map([__CLASS__, 'removeEntries'], $value);
    }

    return $value;
  }
}
