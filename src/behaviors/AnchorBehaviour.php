<?php

namespace lenz\contentfield\behaviors;

use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\services\anchors\AnchorInterface;
use lenz\contentfield\services\anchors\Manager;
use yii\base\Behavior;

/**
 * Class AnchorBehaviour
 *
 * @property InstanceValue $owner
 */
class AnchorBehaviour extends Behavior
{
  /** @var AnchorInterface|null */
  private AnchorInterface|null $_anchor;

  /** @var Manager */
  private Manager $_manager;


  /**
   * @return string
   */
  public function __toString(): string {
    $anchor = $this->getAnchor();
    return is_null($anchor) ? '' : $anchor->getId();
  }

  /**
   * @return AnchorInterface[]
   */
  public function getAllAnchors(): array {
    return $this->getManager()->anchors;
  }

  /**
   * @return AnchorInterface|null
   */
  public function getAnchor(): ?AnchorInterface {
    if (!isset($this->_anchor)) {
      $this->_anchor = $this->getManager()->findInstanceAnchor($this->owner);
    }

    return $this->_anchor;
  }

  /**
   * @return bool
   * @noinspection PhpUnused (Public API)
   */
  public function hasAnchor(): bool {
    return !is_null($this->getAnchor());
  }

  /**
   * @param AnchorInterface|null $value
   * @return void
   */
  public function setAnchor(AnchorInterface|null $value): void {
    $this->_anchor = $value;
  }


  // Private methods
  // ---------------

  /**
   * @return Manager
   */
  private function getManager(): Manager {
    $rootBehaviour = $this->getRootBehaviour();
    if (!isset($rootBehaviour->_manager)) {
      $rootBehaviour->_manager = new Manager($rootBehaviour->owner);
    }

    return $rootBehaviour->_manager;
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
}
