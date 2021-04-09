<?php

namespace lenz\contentfield\helpers\listeners;

use craft\elements\Asset;
use craft\events\ElementEvent;
use craft\events\RegisterCacheOptionsEvent;
use craft\services\Elements;
use craft\utilities\ClearCaches;
use lenz\contentfield\Plugin;
use yii\base\Event;
use yii\caching\TagDependency;

/**
 * Class Caches
 */
class Caches
{
  /**
   * @param ElementEvent $event
   */
  static public function onAfterModifyElement(ElementEvent $event) {
    if ($event->element instanceof Asset) {
      TagDependency::invalidate(Plugin::getInstance()->imageTagCache, $event->element->uid);
    }
  }

  /**
   * @param RegisterCacheOptionsEvent $event
   */
  static public function onRegisterCacheOptions(RegisterCacheOptionsEvent $event) {
    $event->options[] = [
      'key'    => 'cache-imagetags',
      'label'  => 'Image tag cache',
      'action' => [Plugin::getInstance()->imageTagCache, 'flush']
    ];
  }

  /**
   * @return void
   */
  static public function register() {
    Event::on(
      Elements::class, Elements::EVENT_AFTER_DELETE_ELEMENT,
      [self::class, 'onAfterModifyElement']
    );

    Event::on(
      Elements::class, Elements::EVENT_AFTER_SAVE_ELEMENT,
      [self::class, 'onAfterModifyElement']
    );

    Event::on(
      ClearCaches::class, ClearCaches::EVENT_REGISTER_CACHE_OPTIONS,
      [self::class, 'onRegisterCacheOptions']
    );
  }
}
