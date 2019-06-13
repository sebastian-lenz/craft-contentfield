<?php

namespace lenz\contentfield;

use Craft;
use craft\controllers\TemplatesController;
use craft\events\RegisterComponentTypesEvent;
use craft\events\TemplateEvent;
use craft\services\Fields;
use craft\services\Utilities;
use craft\web\Application;
use craft\web\Response;
use craft\web\View;
use Exception;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\fields\ContentField;
use lenz\contentfield\models\Content;
use lenz\contentfield\utilities\Utility;
use lenz\contentfield\utilities\SourcesUtility;
use lenz\contentfield\utilities\TemplateLoader;
use lenz\contentfield\utilities\twig\Extension;
use Twig\Environment;
use yii\base\ActionEvent;
use yii\base\Event;
use yii\web\NotFoundHttpException;

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
   * @var string
   */
  static $TRANSLATION_CATEGORY = 'site';

  /**
   * @var string
   */
  static $UUID_PARAM = 'content-uuid';


  /**
   * @param View $view
   */
  public function applyTemplateLoader(View $view) {
    $twig = $view->getTwig();
    if (!($twig->getLoader() instanceof TemplateLoader)) {
      $twig->setLoader(new TemplateLoader($view));
    }
  }

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

    Craft::$app->view->registerTwigExtension(new Extension());

    Event::on(
      View::class,
      View::EVENT_BEFORE_RENDER_PAGE_TEMPLATE,
      [$this, 'onBeforeRenderAnyTemplate']
    );

    Event::on(
      View::class,
      View::EVENT_BEFORE_RENDER_TEMPLATE,
      [$this, 'onBeforeRenderAnyTemplate']
    );

    Event::on(
      Fields::class,
      Fields::EVENT_REGISTER_FIELD_TYPES,
      [$this, 'onRegisterFieldTypes']
    );

    Event::on(
      Utilities::class,
      Utilities::EVENT_REGISTER_UTILITY_TYPES,
      [$this, 'onRegisterUtilityTypes']
    );

    Event::on(
      Application::class,
      Application::EVENT_BEFORE_ACTION,
      [$this, 'onBeforeAction']
    );
  }

  /**
   * @param ActionEvent $event
   * @throws Exception
   */
  public function onBeforeAction(ActionEvent $event) {
    $element = Craft::$app->getUrlManager()->getMatchedElement();
    $isRenderRequest = (
      $event->action->controller instanceof TemplatesController &&
      $event->action->id == 'render'
    );

    if (!$element || !$isRenderRequest) {
      return;
    }

    $uuid = Craft::$app->getRequest()->getParam(self::$UUID_PARAM);
    $isChunkRequest = $isRenderRequest && !is_null($uuid);
    $pageTemplate = null;

    foreach ($element->getFieldValues() as $fieldValue) {
      if ($fieldValue instanceof Content) {
        $fieldValue->onBeforeAction(new BeforeActionEvent([
          'originalEvent' => $event,
          'requestedUuid' => $isChunkRequest ? $uuid : null,
        ]));

        if ($fieldValue->getField()->useAsPageTemplate) {
          $pageTemplate = $fieldValue;
        }
      }
    };

    if ($isChunkRequest && $event->isValid) {
      throw new NotFoundHttpException();
    } elseif (!is_null($pageTemplate)) {
      $event->isValid = false;
      $this->sendPageTemplate($pageTemplate);
    }
  }

  /**
   * @param TemplateEvent $event
   */
  public function onBeforeRenderAnyTemplate(TemplateEvent $event) {
    $this->applyTemplateLoader($event->sender);
  }

  /**
   * @param RegisterComponentTypesEvent $event
   */
  public function onRegisterFieldTypes(RegisterComponentTypesEvent $event) {
    $event->types[] = ContentField::class;
  }

  /**
   * @param RegisterComponentTypesEvent $event
   */
  public function onRegisterUtilityTypes(RegisterComponentTypesEvent $event) {
    $event->types[] = Utility::class;
  }


  // Protected methods
  // -----------------

  /**
   * @inheritdoc
   */
  protected function createSettingsModel() {
    return new Config();
  }

  /**
   * @param Content $content
   */
  protected function sendPageTemplate(Content $content) {
    $routeParams = Craft::$app->getUrlManager()->getRouteParams();

    $response = Craft::$app->getResponse();
    $response->format = Response::FORMAT_HTML;
    $response->data = $content->render(
      $routeParams['variables']
    );
  }


  // Static methods
  // --------------

  /**
   * @param string $value
   * @return string
   */
  public static function t($value) {
    return empty($value)
      ? $value
      : Craft::t(self::$TRANSLATION_CATEGORY, $value);
  }
}
