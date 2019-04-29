<?php

namespace lenz\contentfield\utilities;

use craft\base\ElementInterface;

/**
 * Class ReferenceMap
 */
class ReferenceMap
{
  /**
   * @var array
   */
  private $elementTypes = [];


  /**
   * @param string $elementType
   * @return int[]
   */
  public function getElementIds($elementType) {
    $elementType = self::normalizeElementType($elementType);

    return array_key_exists($elementType, $this->elementTypes)
      ? $this->elementTypes[$elementType]
      : array();
  }

  /**
   * @param string $elementType
   * @param int $id
   */
  public function push($elementType, $id) {
    $elementType = self::normalizeElementType($elementType);

    if (!array_key_exists($elementType, $this->elementTypes)) {
      $this->elementTypes[$elementType] = array();
    }

    if (!in_array($id, $this->elementTypes[$elementType])) {
      $this->elementTypes[$elementType][] = $id;
    }
  }

  /**
   * @return ElementInterface[]
   */
  public function queryAll() {
    $result = array();

    foreach ($this->elementTypes as $elementType => $ids) {
      /** @var ElementInterface $elementType */
      $elements = $elementType::find()
        ->id($ids)
        ->all();

      $result = array_merge($result, $elements);
    }

    return $result;
  }

  /**
   * @param string $elementType
   * @return string
   */
  static public function normalizeElementType($elementType) {
    return trim($elementType, '\\');
  }
}
