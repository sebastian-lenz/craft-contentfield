<?php

namespace lenz\contentfield\behaviors;

use craft\helpers\StringHelper;
use lenz\contentfield\models\values\ArrayValue;
use lenz\contentfield\models\values\InstanceValue;
use yii\base\Behavior;

/**
 * Class AnchorBehaviour
 *
 * @property InstanceValue $owner
 */
class AnchorBehaviour extends Behavior
{
  /**
   * @var string|null
   */
  private $_anchor;

  /**
   * @var AnchorBehaviour[]
   */
  private $_childAnchors;

  /**
   * @var string|null
   */
  private $_rawValue;


  /**
   * @return AnchorBehaviour[]
   */
  public function getAllAnchors(): array {
    return $this->getRootBehaviour()->getChildAnchors();
  }

  /**
   * @return string|null
   */
  public function getAnchor(): ?string {
    if (!isset($this->_anchor)) {
      $this->getRootBehaviour()->generateAnchors();
    }

    return $this->_anchor;
  }

  /**
   * @return string|null
   */
  public function getRawValue(): ?string {
    if (!isset($this->_rawValue)) {
      $this->_rawValue = $this->loadRawValue();
    }

    return $this->_rawValue;
  }

  /**
   * @return bool
   */
  public function hasAnchor(): bool {
    return !is_null($this->getRawValue());
  }


  // Private methods
  // ---------------

  /**
   * @param ArrayValue $value
   */
  private function collectArrayAnchors(ArrayValue $value) {
    foreach ($value->getValues() as $item) {
      if ($item instanceof InstanceValue) {
        self::collectInstanceAnchors($item);
      }
    }
  }

  /**
   * @param InstanceValue $instance
   */
  private function collectInstanceAnchors(InstanceValue $instance) {
    if ($instance->hasAnchor()) {
      $this->_childAnchors[] = $instance->getBehavior('anchor');
    }

    foreach ($instance->getAttributes() as $name => $value) {
      if ($value instanceof ArrayValue) {
        $this->collectArrayAnchors($value);
      } elseif ($value instanceof InstanceValue) {
        $this->collectInstanceAnchors($value);
      }
    }
  }

  /**
   * @return void
   */
  private function generateAnchors() {
    $ids = [];
    foreach ($this->getChildAnchors() as $anchor) {
      $slug = StringHelper::slugify($anchor->getRawValue());
      $id = $slug;
      $index = 0;

      while (in_array($id, $ids) && $index < 50) {
        $id = $slug . '-' . (++$index);
      }

      $ids[] = $id;
      $anchor->_anchor = $id;
    }
  }

  /**
   * @return AnchorBehaviour[]
   */
  private function getChildAnchors(): array {
    if (!isset($this->_childAnchors)) {
      $this->_childAnchors = [];
      $this->collectInstanceAnchors($this->owner);
    }

    return $this->_childAnchors;
  }

  /**
   * @return AnchorBehaviour
   */
  private function getRootBehaviour(): AnchorBehaviour {
    $root = $this->owner->getRoot();

    return $root instanceof InstanceValue
      ? $root->getBehavior('anchor')
      : $this;
  }

  /**
   * @return string|null
   */
  private function loadRawValue(): ?string {
    $fields = self::parseAnchorFields($this->owner->getSchema()->anchor);
    if (!is_array($fields)) {
      return null;
    }

    foreach ($fields as $field) {
      $value = trim((string)$this->owner->offsetGet($field));
      if (!empty($value)) {
        return $value;
      }
    }

    return null;
  }


  // Static methods
  // --------------

  /**
   * @param mixed $value
   * @return string[]|null
   */
  static public function parseAnchorFields($value): ?array {
    if (empty($value)) {
      return null;
    }

    if (!is_array($value)) {
      $value = explode(',', $value);
    }

    return array_filter(array_map('trim', $value));
  }
}
