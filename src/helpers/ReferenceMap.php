<?php

namespace lenz\contentfield\helpers;

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
   * @var array
   */
  private $_with = [];


  /**
   * @param string $elementType
   * @return int[]
   */
  public function getElementIds(string $elementType): array {
    $elementType = self::normalizeElementType($elementType);

    return array_key_exists($elementType, $this->_elementTypes)
      ? $this->_elementTypes[$elementType]
      : [];
  }

  /**
   * @param string $elementType
   * @return array
   */
  public function getWith(string $elementType): array {
    return array_key_exists($elementType, $this->_with)
      ? $this->_with[$elementType]
      : [];
  }

  /**
   * @param string $elementType
   * @return bool
   */
  public function hasWith(string $elementType): bool {
    return (
      array_key_exists($elementType, $this->_with) &&
      count($this->_with[$elementType]) > 0
    );
  }

  /**
   * @param string $elementType
   * @param int $id
   */
  public function push(string $elementType, int $id) {
    $elementType = self::normalizeElementType($elementType);

    if (!array_key_exists($elementType, $this->_elementTypes)) {
      $this->_elementTypes[$elementType] = [];
    }

    if (!in_array($id, $this->_elementTypes[$elementType])) {
      $this->_elementTypes[$elementType][] = $id;
    }
  }

  /**
   * @param int|null $siteId
   * @return ElementInterface[]
   */
  public function queryAll(int $siteId = null): array {
    $result = [];

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
   * @param string|string[] $values
   */
  public function with(string $elementType, $values) {
    if (!is_array($values)) {
      $values = [$values];
    }

    $with = array_key_exists($elementType, $this->_with)
      ? $this->_with[$elementType]
      : [];

    foreach ($values as $value) {
      if (!is_string($value) || empty($value) || in_array($value, $with)) {
        continue;
      }

      $with[] = $value;
    }

    $this->_with[$elementType] = $with;
  }


  // Static methods
  // --------------

  /**
   * @param string $elementType
   * @return string
   */
  static public function normalizeElementType(string $elementType): string {
    return trim($elementType, '\\');
  }
}
