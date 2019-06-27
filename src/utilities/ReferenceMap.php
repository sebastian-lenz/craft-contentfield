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
  private $_elementTypes = [];


  /**
   * @param string $elementType
   * @return int[]
   */
  public function getElementIds($elementType) {
    $elementType = self::normalizeElementType($elementType);

    return array_key_exists($elementType, $this->_elementTypes)
      ? $this->_elementTypes[$elementType]
      : array();
  }

  /**
   * @param string $elementType
   * @param int $id
   */
  public function push($elementType, $id) {
    $elementType = self::normalizeElementType($elementType);

    if (!array_key_exists($elementType, $this->_elementTypes)) {
      $this->_elementTypes[$elementType] = array();
    }

    if (!in_array($id, $this->_elementTypes[$elementType])) {
      $this->_elementTypes[$elementType][] = $id;
    }
  }

  /**
   * @param int|null $siteId
   * @return ElementInterface[]
   */
  public function queryAll($siteId = null) {
    $result = array();

    foreach ($this->_elementTypes as $elementType => $ids) {
      /** @var ElementInterface $elementType */
      $elements = $elementType::find()
        ->id($ids)
        ->siteId($siteId)
        ->status(null)
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
