<?php

namespace lenz\contentfield;

use Craft;
use craft\controllers\TemplatesController;
use craft\events\ExceptionEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\events\TemplateEvent;
use craft\services\Fields;
use craft\services\Utilities;
use craft\web\Application;
use craft\web\ErrorHandler;
use craft\web\Response;
use craft\web\View;
use Exception;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\fields\ContentField;
use lenz\contentfield\models\Content;
use lenz\contentfield\utilities\twig\Extension;
use lenz\contentfield\utilities\twig\YamlAwareTemplateLoader;
use lenz\contentfield\utilities\Utility;
use Twig\Error\RuntimeError;
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
  public $schemaVersion = '1.1.2';

  /**
   * @var string
   */
  static $TRANSLATION_CATEGORY = 'site';

  /**
   * @var string
   */
  static $UUID_PARAM = 'content-uuid';


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

    Event::on(
      ErrorHandler::class,
      ErrorHandler::EVENT_BEFORE_HANDLE_EXCEPTION,
      [$this, 'onBeforeHandleException']
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

    $uuid           = Craft::$app->getRequest()->getParam(self::$UUID_PARAM);
    $isChunkRequest = $isRenderRequest && !is_null($uuid);
    $pageTemplate   = null;

    foreach ($element->getFieldValues() as $fieldValue) {
      if ($fieldValue instanceof Content) {
        $fieldValue->onBeforeAction(new BeforeActionEvent([
          'originalEvent' => $event,
          'requestedUuid' => $isChunkRequest ? $uuid : null,
        ]));
      }
    };

    // If this was a chunk request and we did not resolve it, raise
    // an error
    if ($isChunkRequest && $event->isValid) {
      throw new NotFoundHttpException();
    }
  }

  /**
   * @param ExceptionEvent $event
   */
  public function onBeforeHandleException(ExceptionEvent $event) {
    if ($event->exception instanceof RuntimeError) {
      $error  = $event->exception;
      $source = $error->getSourceContext();
      $loader = Craft::$app->getView()->getTwig()->getLoader();

      if ($loader instanceof YamlAwareTemplateLoader) {
        $offset = $loader->getSourceOffset($source->getName());
        $error->setTemplateLine($error->getLine() + $offset);
      }
    }
  }

  /**
   * @param TemplateEvent $event
   */
  public function onBeforeRenderAnyTemplate(TemplateEvent $event) {
    $view = $event->sender;

    if ($view instanceof View) {
      $twig = $view->getTwig();

      if (!($twig->getLoader() instanceof YamlAwareTemplateLoader)) {
        $twig->setLoader(new YamlAwareTemplateLoader($view));
      }
    }
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
