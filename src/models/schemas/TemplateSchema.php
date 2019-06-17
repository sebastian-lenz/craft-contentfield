<?php

namespace lenz\contentfield\models\schemas;

use Craft;
use craft\web\twig\Environment;
use craft\web\View;
use lenz\contentfield\controllers\EntriesController;
use lenz\contentfield\controllers\TemplatesController;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\Plugin;
use lenz\contentfield\utilities\twig\YamlAwareTemplateLoader;
use Throwable;
use Twig\TemplateWrapper;
use yii\base\Exception;

/**
 * Class TemplateSchema
 */
class TemplateSchema extends AbstractSchema
{
  /**
   * @var string
   */
  public $model;

  /**
   * @var string
   */
  public $path;

  /**
   * @var string
   */
  public $template;

  /**
   * @var TemplateWrapper
   */
  private $_template;

  /**
   * @var Environment
   */
  static private $_twig;


  /**
   * @param BeforeActionEvent $event
   * @param Content $content
   */
  public function applyPageTemplate(BeforeActionEvent $event, Content $content) {
    $action = $event->originalEvent->action;
    $module = Plugin::getInstance();
    $config = [
      'content'  => $content,
      'mimeType' => $this->mimeType,
    ];

    $action->controller =  $event->isPreviewRequest
      ? new EntriesController('entries', $module, $config)
      : new TemplatesController('templates', $module, $config);
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function display(InstanceValue $instance, array $variables = []) {
    $this->getTemplate()->display(
      $this->getNormalizedVariables($instance, $variables)
    );
  }

  /**
   * @param string $qualifier
   * @return string
   */
  public function normalizeQualifier(string $qualifier) {
    if (!preg_match('/^[^:]+:/', $qualifier)) {
      $qualifier = 'template:' . $qualifier;
    }

    if (
      substr($qualifier, 0, 9) == 'template:' &&
      substr($qualifier, -5) != '.twig'
    ) {
      $qualifier .= '.twig';
    }

    return $qualifier;
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function render(InstanceValue $instance, array $variables = [], array $options = []) {
    $variables = $this->getNormalizedVariables($instance, $variables);
    $view = array_key_exists('view', $options) && $options['view'] instanceof View
      ? $options['view']
      : null;

    return is_null($view)
      ? $this->getTemplate()->render($variables)
      : $view->renderPageTemplate($this->template, $variables);
  }


  // Private methods
  // ---------------

  /**
   * @param InstanceValue $instance
   * @param array $variables
   * @return array
   */
  private function getNormalizedVariables(InstanceValue $instance, array $variables) {
    return array_merge(
      [
        'entry'    => $instance->getContent()->getOwner(),
        'instance' => $instance,
      ],
      $instance->getValues(),
      $variables
    );
  }

  /**
   * @return TemplateWrapper
   * @throws Throwable
   */
  private function getTemplate() {
    if (!isset($this->_template)) {
      $this->_template = self::getTwig()->load($this->template);
    }

    return $this->_template;
  }


  // Static methods
  // --------------

  /**
   * @return Environment
   * @throws Exception
   */
  static function getTwig() {
    if (!isset(self::$_twig)) {
      self::$_twig = YamlAwareTemplateLoader::getSiteTwig(
        Craft::$app->getView()
      );
    }

    return self::$_twig;
  }
}
