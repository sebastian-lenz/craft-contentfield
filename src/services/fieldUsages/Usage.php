<?php

namespace lenz\contentfield\services\fieldUsages;

use yii\BaseYii;

/**
 * Class Usage
 *
 * Stores generic information about the usage of a field within
 * a field layout.
 */
class Usage
{
  /**
   * @var Usage[]
   */
  public array $children = [];

  /**
   * @var string
   */
  public string $name;

  /**
   * @var string
   */
  public string $type;

  /**
   * @var string
   */
  public string $uid;


  /**
   * FieldUsage constructor.
   * @param array $options
   */
  public function __construct(array $options = []) {
    BaseYii::configure($this, $options);
  }

  /**
   * @param array $options
   * @return Usage
   */
  public function findOrCreate(array $options): Usage {
    foreach ($this->children as $child) {
      if ($child->uid == $options['uid']) {
        return $child;
      }
    }

    $child = new Usage($options);
    $this->children[] = $child;
    return $child;
  }

  /**
   * @return Usage[]
   */
  public function getFlattened(): array {
    $result = [];
    foreach ($this->children as $child) {
      $result[] = $child;
      $result = array_merge($result, $child->getFlattened());
    }

    return $result;
  }

  /**
   * @return void
   */
  public function sortChildren(): void {
    uasort($this->children, function(Usage $a, Usage $b) {
      return strcmp($a->name, $b->name);
    });

    foreach ($this->children as $child) {
      $child->sortChildren();
    }
  }
}
