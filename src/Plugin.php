<?php

namespace lenz\contentfield;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\controllers\TemplatesController;
use craft\events\ExceptionEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\events\TemplateEvent;
use craft\services\Fields;
use craft\services\Utilities;
use craft\web\Application;
use craft\web\ErrorHandler;
use craft\web\View;
use Exception;
use lenz\contentfield\assets\preview\ContentFieldPreviewAsset;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\fields\ContentField;
use lenz\contentfield\models\Content;
use lenz\contentfield\twig\Extension;
use lenz\contentfield\twig\YamlAwareTemplateLoader;
use lenz\contentfield\utilities\Utility;
use Throwable;
use Twig\Error\RuntimeError;
use yii\base\ActionEvent;
use yii\base\Event;
use yii\web\NotFoundHttpException;

/**
 * Class Plugin
 *
 * @property services\definitions\FieldDefinitions $fields
 * @property services\FieldUsage $fieldUsage
 * @property services\definitions\ImageTagDefinitions $imageTags
 * @property services\Relations $relations
 * @property services\Schemas $schemas
 * @property services\definitions\StructureDefinitions $structures
 * @property services\Translators $translators
 * @method Config getSettings()
 */
class Plugin extends BasePlugin
{
  /**
   * @var bool
   */
  public $hasCpSettings = true;

  /**
   * @inheritdoc
   */
  public $schemaVersion = '1.1.2';

  /**
   * @var bool
   */
  static $IS_ELEMENT_PREVIEW = false;

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
        'class' => services\definitions\FieldDefinitions::class,
      ],
      'fieldUsage' => [
        'class' => services\FieldUsage::class,
      ],
      'imageTags' => [
        'class' => services\definitions\ImageTagDefinitions::class,
      ],
      'relations' => [
        'class' => services\Relations::class,
      ],
      'schemas' => [
        'class' => services\Schemas::class,
      ],
      'structures' => [
        'class' => services\definitions\StructureDefinitions::class,
      ],
      'translators' => [
        'class' => services\Translators::class,
      ],
    ]);

    Craft::$app->view->registerTwigExtension(new Extension());

    Event::on(
      View::class, View::EVENT_BEFORE_RENDER_PAGE_TEMPLATE,
      [$this, 'onBeforeRenderAnyTemplate']
    );

    Event::on(
      View::class, View::EVENT_BEFORE_RENDER_TEMPLATE,
      [$this, 'onBeforeRenderAnyTemplate']
    );

    Event::on(
      Fields::class, Fields::EVENT_REGISTER_FIELD_TYPES,
      [$this, 'onRegisterFieldTypes']
    );

    Event::on(
      Utilities::class, Utilities::EVENT_REGISTER_UTILITY_TYPES,
      [$this, 'onRegisterUtilityTypes']
    );

    Event::on(
      Application::class, Application::EVENT_BEFORE_ACTION,
      [$this, 'onBeforeAction']
    );

    Event::on(
      ErrorHandler::class, ErrorHandler::EVENT_BEFORE_HANDLE_EXCEPTION,
      [$this, 'onBeforeHandleException']
    );
  }

  /**
   * @param ActionEvent $event
   * @throws Exception
   */
  public function onBeforeAction(ActionEvent $event) {
    $action = $event->action;
    if (
      $action->controller instanceof TemplatesController &&
      $action->id == 'render'
    ) {
      $this->onBeforeRenderAction($event);
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

    if (
      $view instanceof View &&
      $view->getTemplateMode() == View::TEMPLATE_MODE_SITE
    ) {
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
   * @param ActionEvent $event
   * @throws Exception
   */
  protected function onBeforeRenderAction(ActionEvent $event) {
    $element          = Craft::$app->getUrlManager()->getMatchedElement();
    $request          = Craft::$app->getRequest();
    $uuid             = $request->getParam(self::$UUID_PARAM);
    $isPreviewRequest = $request->getIsPreview();
    $isChunkRequest   = !is_null($uuid);
    $pageTemplate     = null;

    if (!$element) {
      return;
    }

    // Remember if this is a preview request and add the preview
    // helper assets
    if ($isPreviewRequest) {
      self::$IS_ELEMENT_PREVIEW = true;
      Craft::$app
        ->getView()
        ->registerAssetBundle(ContentFieldPreviewAsset::class);
    }

    // Invoke onBeforeAction on all content fields
    foreach ($element->getFieldValues() as $fieldValue) {
      if ($fieldValue instanceof Content) {
        $fieldValue->onBeforeAction(new BeforeActionEvent([
          'isPreviewRequest' => $isPreviewRequest,
          'originalEvent'    => $event,
          'requestedUuid'    => $isChunkRequest ? $uuid : null,
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
   * @return string|null
   * @throws Throwable
   */
  protected function settingsHtml() {
    return Craft::$app->getView()->renderTemplate('contentfield/_config', [
      'config'      => $this->getSettings(),
      'translators' => $this->translators,
    ]);
  }


  // Static methods
  // --------------

  /**
   * @param string $value
   * @return string
   */
  static public function t($value) {
    return empty($value)
      ? $value
      : Craft::t(self::$TRANSLATION_CATEGORY, $value);
  }
}
