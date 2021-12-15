<?php

namespace lenz\contentfield\helpers\listeners;

use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use craft\services\Utilities;
use lenz\contentfield\fields\ContentField;
use lenz\contentfield\utilities\Utility;
use yii\base\Event;

/**
 * Class Registry
 */
class Registry
{
  /**
   * @param RegisterComponentTypesEvent $event
   */
  static public function onRegisterFieldTypes(RegisterComponentTypesEvent $event) {
    $event->types[] = ContentField::class;
  }

  /**
   * @param RegisterComponentTypesEvent $event
   */
  static public function onRegisterUtilityTypes(RegisterComponentTypesEvent $event) {
    $event->types[] = Utility::class;
  }

  /**
   * @return void
   */
  static public function register() {
    Event::on(
      Fields::class, Fields::EVENT_REGISTER_FIELD_TYPES,
      [self::class, 'onRegisterFieldTypes']
    );

    Event::on(
      Utilities::class, Utilities::EVENT_REGISTER_UTILITY_TYPES,
      [self::class, 'onRegisterUtilityTypes']
    );
  }
}
