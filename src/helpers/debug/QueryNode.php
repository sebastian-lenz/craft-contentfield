<?php

namespace lenz\contentfield\helpers\debug;

/**
 * Class QueryNode
 */
class QueryNode
{
  /**
   * @var QueryNode[]
   */
  public $children = [];

  /**
   * @var string
   */
  public $name = null;

  /**
   * @var QueryInfo[]
   */
  public $queries = [];

  /**
   * @var string
   */
  public $type = self::TYPE_ROOT;

  /**
   * Known node types.
   */
  const TYPE_ROOT = 'root';
  const TYPE_TEMPLATE = 'template';


  /**
   * @param QueryInfo $query
   */
  public function addQuery(QueryInfo $query) {
    $this->queries[] = $query;
  }

  /**
   * @param string $template
   * @return QueryNode
   */
  public function getTemplateChild(string $template) {
    foreach ($this->children as $child) {
      if ($child->name == $template && $child->type == self::TYPE_TEMPLATE) {
        return $child;
      }
    }

    $child = new QueryNode();
    $child->name = $template;
    $child->type = self::TYPE_TEMPLATE;
    $this->children[] = $child;
    return $child;
  }

  /**
   * @return bool
   */
  public function hasQueries() {
    return count($this->queries) > 0;
  }
}
