<?php

namespace lenz\contentfield\helpers\listeners;

use Craft;
use craft\controllers\TemplatesController;
use craft\web\Application;
use Exception;
use lenz\contentfield\assets\preview\ContentFieldPreviewAsset;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\helpers\debug\ElementQueryPanel;
use lenz\contentfield\models\Content;
use lenz\contentfield\Plugin;
use yii\base\ActionEvent;
use yii\base\Event;
use yii\debug\Module as DebugModule;
use yii\web\NotFoundHttpException;

/**
 * Class Frontend
 */
class Frontend
{
  /**
   * @return void
   */
  static public function onBeforeRequest(): void {
    if (YII_DEBUG) {
      $debugger = Craft::$app->getModule('debug');

      if ($debugger instanceof DebugModule) {
        $debugger->panels[ElementQueryPanel::ID] = new ElementQueryPanel();
      }
    }
  }

  /**
   * @param ActionEvent $event
   * @throws Exception
   */
  static public function onBeforeAction(ActionEvent $event): void {
    $action = $event->action;
    if (
      $action->controller instanceof TemplatesController &&
      $action->id == 'render'
    ) {
      self::onBeforeRenderAction($event);
    }
  }

  /**
   * @return void
   */
  static public function register(): void {
    Event::on(
      Application::class, Application::EVENT_BEFORE_ACTION,
      [self::class, 'onBeforeAction']
    );

    Event::on(Application::class, Application::EVENT_BEFORE_REQUEST,
      [self::class, 'onBeforeRequest']
    );
  }


  // Private methods
  // ---------------

  /**
   * @param ActionEvent $event
   * @throws Exception
   */
  private static function onBeforeRenderAction(ActionEvent $event): void {
    $element = Craft::$app->urlManager->getMatchedElement();
    $request = Craft::$app->request;
    $uuid = $request->getParam(Plugin::$UUID_PARAM);
    $isPreviewRequest = $request->getIsPreview();
    $isChunkRequest = !is_null($uuid);

    if (!$element) {
      return;
    }

    // Remember if this is a preview request and add the preview
    // helper assets
    if ($isPreviewRequest) {
      Plugin::$IS_ELEMENT_PREVIEW = true;
      Craft::$app
        ->getView()
        ->registerAssetBundle(ContentFieldPreviewAsset::class);
    }

    // Invoke onBeforeAction on all content fields
    foreach ($element->getFieldValues() as $fieldValue) {
      if ($fieldValue instanceof Content) {
        $fieldValue->onBeforeAction(new BeforeActionEvent([
          'isPreviewRequest' => $isPreviewRequest,
          'originalEvent' => $event,
          'requestedUuid' => $isChunkRequest ? $uuid : null,
        ]));
      }
    }

    // If this was a chunk request and we did not resolve it, raise
    // an error
    if ($isChunkRequest && $event->isValid) {
      throw new NotFoundHttpException();
    }
  }
}
