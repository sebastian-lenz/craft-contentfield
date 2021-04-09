<?php

namespace lenz\contentfield\helpers\listeners;

use Craft;
use craft\events\ExceptionEvent;
use craft\events\TemplateEvent;
use craft\web\ErrorHandler;
use craft\web\View;
use lenz\contentfield\twig\YamlAwareTemplateLoader;
use Twig\Error\SyntaxError;
use yii\base\Event;

/**
 * Class YamlLoader
 */
class YamlLoader
{
  /**
   * @param ExceptionEvent $event
   */
  static public function onBeforeHandleException(ExceptionEvent $event) {
    if ($event->exception instanceof SyntaxError) {
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
  static public function onBeforeRenderAnyTemplate(TemplateEvent $event) {
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
   * @return void
   */
  static public function register() {
    Event::on(
      View::class, View::EVENT_BEFORE_RENDER_PAGE_TEMPLATE,
      [self::class, 'onBeforeRenderAnyTemplate']
    );

    Event::on(
      View::class, View::EVENT_BEFORE_RENDER_TEMPLATE,
      [self::class, 'onBeforeRenderAnyTemplate']
    );

    Event::on(
      ErrorHandler::class, ErrorHandler::EVENT_BEFORE_HANDLE_EXCEPTION,
      [self::class, 'onBeforeHandleException']
    );
  }
}
