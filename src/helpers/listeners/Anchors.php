<?php

namespace lenz\contentfield\helpers\listeners;

use craft\base\ElementInterface;
use lenz\contentfield\behaviors\AnchorBehaviour;
use lenz\contentfield\models\Content;
use lenz\craft\utils\events\AnchorEvent;
use lenz\craft\utils\events\AnchorsEvent;
use yii\base\Event;

/**
 * Class Anchors
 */
class Anchors
{
  /**
   * @param AnchorsEvent $event
   */
  static public function onFindAnchors(AnchorsEvent $event): void {
    self::eachAnchors($event->getElement(), function(AnchorBehaviour $anchors) use ($event) {
      foreach ($anchors->getAllAnchors() as $anchor) {
        $event->addAnchor(
          $anchor->getAnchor(),
          $anchor->getAnchorTitle(),
          $anchor->owner->getUuid()
        );
      }
    });
  }

  /**
   * @param AnchorEvent $event
   */
  static public function onResolveAnchorId(AnchorEvent $event): void {
    self::eachAnchors($event->getElement(), function(AnchorBehaviour $anchors) use ($event) {
      foreach ($anchors->getAllAnchors() as $anchor) {
        if ($anchor->owner->getUuid() == $event->id) {
          $event->anchor = $anchor->getAnchor();
        }
      }
    });
  }

  /**
   * @return void
   */
  static public function register(): void {
    Event::on(
      AnchorEvent::class, AnchorEvent::EVENT_RESOLVE_ANCHOR_ID,
      [self::class, 'onResolveAnchorId']
    );

    Event::on(
      AnchorsEvent::class, AnchorsEvent::EVENT_FIND_ANCHORS,
      [self::class, 'onFindAnchors']
    );
  }


  // Private methods
  // ---------------

  /**
   * @param ElementInterface|null $element
   * @param callable $callback
   */
  private static function eachAnchors(?ElementInterface $element, callable $callback): void {
    $values = is_null($element) ? [] : $element->getFieldValues();

    foreach ($values as $value) {
      $model = $value instanceof Content ? $value->getModel() : null;
      $anchors = $model ? $model->getBehavior('anchor') : null;
      if ($anchors instanceof AnchorBehaviour) {
        $callback($anchors);
      }
    }
  }
}
