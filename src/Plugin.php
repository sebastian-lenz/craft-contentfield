<?php

namespace sebastianlenz\contentfield;

use craft\events\RegisterComponentTypesEvent;
use craft\events\TemplateEvent;
use craft\services\Fields;
use craft\services\Utilities;
use craft\web\View;
use yii\base\Event;

use sebastianlenz\contentfield\fields\ContentField;
use sebastianlenz\contentfield\utilities\IconUtility;
use sebastianlenz\contentfield\utilities\TemplateLoader;

/**
 * Class Plugin
 *
 * @property services\FieldManager $fields
 * @property services\ImageTags $imageTags
 * @property services\Relations $relations
 * @property services\SchemaManager $schemas
 * @method Config getSettings()
 */
class Plugin extends \craft\base\Plugin
{
  /**
   * @inheritdoc
   */
  public $schemaVersion = '1.1.1';

  /**
   * @var array
   */
  private $patchedViews = array();

  /**
   * @var string
   */
  static $TRANSLATION_CATEGORY = 'site';


  /**
   * @return void
   */
  public function init() {
    parent::init();

    $this->setComponents([
      'fields' => [
        'class' => services\FieldManager::class
      ],
      'imageTags' => [
        'class' => services\ImageTags::class
      ],
      'relations' => [
        'class' => services\Relations::class
      ],
      'schemas' => [
        'class' => services\SchemaManager::class
      ]
    ]);

    Event::on(
      View::class,
      View::EVENT_AFTER_RENDER_PAGE_TEMPLATE,
      function(TemplateEvent $event) {
        /** @var View $view */
        $view = $event->sender;
        if (!in_array($view, $this->patchedViews)) {
          $view->getTwig()->setLoader(new TemplateLoader($view));
          $this->patchedViews[] = $view;
        }
      }
    );

    Event::on(
      View::class,
      View::EVENT_BEFORE_RENDER_TEMPLATE,
      function(TemplateEvent $event) {
        /** @var View $view */
        $view = $event->sender;
        if (!in_array($view, $this->patchedViews)) {
          $view->getTwig()->setLoader(new TemplateLoader($view));
          $this->patchedViews[] = $view;
        }
      }
    );

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
   * @inheritdoc
   */
  protected function createSettingsModel() {
    return new Config();
  }
}
