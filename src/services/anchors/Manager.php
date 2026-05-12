<?php

namespace lenz\contentfield\services\anchors;

use Illuminate\Support\Arr;
use lenz\contentfield\behaviors\AnchorBehaviour;
use lenz\contentfield\models\values\ArrayValue;
use lenz\contentfield\models\values\InstanceValue;

/**
 * Class Manager
 */
readonly class Manager
{
  /** @var AnchorInterface[] */
  public array $anchors;


  /**
   * @param InstanceValue $instance
   */
  public function __construct(
    public InstanceValue $instance,
  ) {
    $this->anchors = self::validateAnchors(
      self::collectInstanceAnchors($this->instance)
    );
  }

  /**
   * @param InstanceValue $instance
   * @return InstanceAnchor|null
   */
  public function findInstanceAnchor(InstanceValue $instance): InstanceAnchor|null {
    $uuid = $instance->getUuid();

    return Arr::first($this->anchors,
      fn($anchor) => $anchor instanceof InstanceAnchor && $anchor->uid === $uuid
    );
  }


  // Private static methods
  // ----------------------

  /**
   * @param ArrayValue $value
   * @return AnchorInterface[]
   */
  private static function collectArrayAnchors(ArrayValue $value): array {
    $result = [];

    foreach ($value->getVisibleValues() as $item) {
      if ($item instanceof InstanceValue) {
        $result = array_merge($result, self::collectInstanceAnchors($item));
      }
    }

    return $result;
  }

  /**
   * @param InstanceValue $instance
   * @return AnchorInterface[]
   */
  private static function collectInstanceAnchors(InstanceValue $instance): array {
    if (!$instance->isVisible()) {
      return [];
    }

    $result = Parser::parseDelegates($instance);
    $anchor = Parser::parseFields($instance);
    if ($anchor) {
      $result[] = $anchor;
    }

    $model = $instance->getModel();
    if ($model instanceof AnchorModelInterface) {
      $result = array_merge($result, $model->getAnchors());
    }

    $behaviour = $instance->getBehavior('anchor');
    if ($behaviour instanceof AnchorBehaviour) {
      $behaviour->anchor = $anchor;
    }

    foreach ($instance->getAttributes() as $value) {
      if ($value instanceof ArrayValue) {
        $result = array_merge($result, self::collectArrayAnchors($value));
      } elseif ($value instanceof InstanceValue) {
        $result = array_merge($result, self::collectInstanceAnchors($value));
      }
    }

    return $result;
  }

  /**
   * @param AnchorInterface[] $anchors
   * @return AnchorInterface[]
   */
  private static function validateAnchors(array $anchors): array {
    $knownIds = [];

    foreach ($anchors as $anchor) {
      $uniqueId = $anchor->getId();
      $index = 0;

      while (in_array($uniqueId, $knownIds) && $index < 50) {
        $uniqueId = $anchor->getId() . '-' . (++$index);
      }

      $knownIds[] = $uniqueId;
      $anchor->setId($uniqueId);
    }

    return $anchors;
  }
}
