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
  private array $_elementTypes = [];

  /**
   * @var array
   */
  private array $_with = [];

  /**
   * @var array
   */
  private array $_withTransforms = [];


  /**
   * @param string $elementType
   * @param int|null $siteId
   * @return int[]
   */
  public function getElementIds(string $elementType, int $siteId = null): array {
    $key = self::key($elementType, $siteId);

    return array_key_exists($key, $this->_elementTypes)
      ? $this->_elementTypes[$key]['ids']
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
   * @return array
   */
  public function getWithTransforms(): array {
    return $this->_withTransforms;
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
   * @param int|null $siteId
   */
  public function push(string $elementType, int $id, int $siteId = null): void {
    $elementType = self::normalizeElementType($elementType);
    $key = self::key($elementType, $siteId);

    if (!array_key_exists($key, $this->_elementTypes)) {
      $this->_elementTypes[$key] = [
        'elementType' => $elementType,
        'ids' => [],
        'siteId' => $siteId,
      ];
    }

    if (!in_array($id, $this->_elementTypes[$key]['ids'])) {
      $this->_elementTypes[$key]['ids'][] = $id;
    }
  }

  /**
   * @param int|null $siteId
   * @return ElementInterface[]
   */
  public function queryAll(int $siteId = null): array {
    $result = [];

    foreach ($this->_elementTypes as $data) {
      /** @var ElementInterface $elementType */
      $elements = $data['elementType']::find()
        ->id($data['ids'])
        ->siteId($data['siteId'] ?: $siteId)
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
  public function with(string $elementType, array|string $values): void {
    $values = self::splitWithValue($values);
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

  /**
   * @param string|string[] $values
   */
  public function withTransforms(array|string $values): void {
    $values = self::splitWithValue($values);

    foreach ($values as $value) {
      if (!in_array($value, $this->_withTransforms)) {
        $this->_withTransforms[] = $value;
      }
    }
  }


  // Static methods
  // --------------

  /**
   * @param string $elementType
   * @param int|null $siteId
   * @return string
   */
  static public function key(string $elementType, int $siteId = null): string {
    $elementType = self::normalizeElementType($elementType);
    return $siteId ? "$elementType:$siteId" : $elementType;
  }

  /**
   * @param string $elementType
   * @return string
   */
  static public function normalizeElementType(string $elementType): string {
    return trim($elementType, '\\');
  }

  /**
   * @param string|string[] $value
   * @return array
   */
  static public function splitWithValue(array|string $value): array {
    return is_array($value)
      ? $value
      : array_filter(array_map('trim', explode(',', $value)));
  }
}
