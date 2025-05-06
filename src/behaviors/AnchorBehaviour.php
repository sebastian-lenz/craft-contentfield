<?php

namespace lenz\contentfield\behaviors;

use craft\helpers\StringHelper;
use lenz\contentfield\models\values\ArrayValue;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\models\values\ReferenceValue;
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
  private ?string $_anchor;

  /**
   * @var AnchorBehaviour[]
   */
  private array $_childAnchors;

  /**
   * @var string|null
   */
  private ?string $_rawValue;

  /**
   * @var string
   */
  public static string $DISABLED_VALUE = '#NULL';


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

    return $this->_anchor ?? null;
  }

  /**
   * @return string|null
   */
  public function getAnchorRawValue(): ?string {
    if (!isset($this->_rawValue)) {
      $this->_rawValue = $this->loadRawValue();
    }

    return $this->_rawValue;
  }

  /**
   * @return string|null
   */
  public function getAnchorTitle(): ?string {
    return $this->getAnchorRawValue();
  }

  /**
   * @return bool
   * @noinspection PhpUnused (Public API)
   */
  public function hasAnchor(): bool {
    return !is_null($this->getAnchorRawValue());
  }

  /**
   * @return string
   */
  public function __toString(): string {
    $anchor = $this->getAnchor();
    return is_null($anchor) ? '' : $anchor;
  }


  // Private methods
  // ---------------

  /**
   * @param ArrayValue $value
   */
  private function collectArrayAnchors(ArrayValue $value): void {
    foreach ($value->getValues() as $item) {
      if ($item instanceof InstanceValue) {
        $this->collectInstanceAnchors($item);
      }
    }
  }

  /**
   * @param InstanceValue $instance
   */
  private function collectInstanceAnchors(InstanceValue $instance): void {
    $anchor = $instance->getBehavior('anchor');
    if ($anchor instanceof AnchorBehaviour) {
      $delegates = $anchor->getDelegates();
      if ($delegates) {
        array_push($this->_childAnchors, ...$delegates);
      } elseif ($anchor->hasAnchor()) {
        $this->_childAnchors[] = $anchor;
      }
    }

    foreach ($instance->getAttributes() as $value) {
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
  private function generateAnchors(): void {
    $ids = [];
    foreach ($this->getChildAnchors() as $anchor) {
      $rawValue = $anchor->getAnchorRawValue();
      if (is_null($rawValue)) {
        $rawValue = $anchor->owner->getUuid();
      }

      $slug = StringHelper::slugify($rawValue);
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
   * @return AnchorBehaviour[]
   */
  private function getDelegates(): array {
    $fields = self::parseAnchorFields($this->owner->getSchema()->anchor, 'delegates');
    $anchors = [];

    foreach ($fields as $field) {
      $value = $this->owner->offsetGet($field[0]);
      if (!($value instanceof ReferenceValue)) {
        continue;
      }

      foreach ($value->getReferences() as $element) {
        $model = $element->{$field[1]}->getModel();
        $anchors = array_merge($anchors, $model->getAllAnchors());
      }
    }

    return $anchors;
  }

  /**
   * @return AnchorBehaviour
   */
  private function getRootBehaviour(): AnchorBehaviour {
    $root = $this->owner->getRoot();
    if (!($root instanceof InstanceValue)) {
      return $this;
    }

    $behaviour = $root->getBehavior('anchor');
    return $behaviour instanceof AnchorBehaviour
      ? $behaviour
      : $this;
  }

  /**
   * @return string|null
   */
  private function loadRawValue(): ?string {
    $fields = self::parseAnchorFields($this->owner->getSchema()->anchor);

    foreach ($fields as $field) {
      $rawValue = $this->owner->offsetGet($field);
      if (is_bool($rawValue)) {
        if (!$rawValue) {
          return null;
        } else {
          continue;
        }
      }

      $value = trim((string)$rawValue);
      if ($value === self::$DISABLED_VALUE) {
        return null;
      }

      if (!empty($value)) {
        return $value;
      }
    }

    return null;
  }


  // Static methods
  // --------------

  /**
   * @param mixed $values
   * @param string $mode
   * @return string[]
   */
  static public function parseAnchorFields(mixed $values, string $mode = 'fields'): array {
    if (empty($values)) {
      return [];
    }

    $values = array_filter(array_map('trim',
      is_array($values) ? $values : explode(',', $values)
    ));

    return match ($mode) {
      'delegates' => array_filter(array_map(
        fn(string $value) => str_starts_with($value, '...')
          ? array_filter(array_map('trim', explode('.', substr($value, 3))))
          : null,
        $values
      )),
      'fields' => array_filter(
        $values,
        fn(string $value) => !str_starts_with($value, '...')
      ),
      default => $values,
    };
  }
}
