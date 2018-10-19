<?php

namespace contentfield;

use craft\events\RegisterComponentTypesEvent;
use craft\events\TemplateEvent;
use craft\services\Fields;
use craft\services\Utilities;
use craft\web\View;
use yii\base\Event;

use contentfield\fields\ContentField;
use contentfield\services\FieldManager;
use contentfield\services\SchemaManager;
use contentfield\utilities\IconUtility;
use contentfield\utilities\TemplateLoader;

/**
 * Class Plugin
 * @package contentfield
 */
class Plugin extends \craft\base\Plugin
{
  private $patchedViews = array();

  /**
   * @var FieldManager
   */
  private static $fieldManager;

  /**
   * @var SchemaManager
   */
  private static $schemaManager;

  /**
   * @var Plugin
   */
  static $instance;

  /**
   * @var string
   */
  static $TRANSLATION_CATEGORY = 'site';

  /**
   * @return void
   */
  public function init() {
    parent::init();
    self::$instance = $this;

    Event::on(View::class, View::EVENT_AFTER_RENDER_PAGE_TEMPLATE, function(TemplateEvent $event) {
      /** @var View $view */
      $view = $event->sender;
      if (!in_array($view, $this->patchedViews)) {
        $view->getTwig()->setLoader(new TemplateLoader($view));
        $this->patchedViews[] = $view;
      }
    });

    Event::on(View::class, View::EVENT_BEFORE_RENDER_TEMPLATE, function(TemplateEvent $event) {
      /** @var View $view */
      $view = $event->sender;
      if (!in_array($view, $this->patchedViews)) {
        $view->getTwig()->setLoader(new TemplateLoader($view));
        $this->patchedViews[] = $view;
      }
    });

    Event::on(
      Fields::class,
      Fields::EVENT_REGISTER_FIELD_TYPES,
      function(RegisterComponentTypesEvent $event) {
        $event->types[] = ContentField::class;
      }
    );

    Event::on(
      Utilities::class,
      Utilities::EVENT_REGISTER_UTILITY_TYPES,
      function(RegisterComponentTypesEvent $event) {
        $event->types[] = IconUtility::class;
      }
    );
  }

  /**
   * @return FieldManager
   */
  static public function getFieldManager() {
    if (!isset(self::$fieldManager)) {
      self::$fieldManager = new FieldManager();
    }

    return self::$fieldManager;
  }

  /**
   * @return SchemaManager
   * @throws \yii\base\Exception
   */
  static public function getSchemaManager() {
    if (!isset(self::$schemaManager)) {
      self::$schemaManager = new SchemaManager();
    }

    return self::$schemaManager;
  }
}
