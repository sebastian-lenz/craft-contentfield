<?php

namespace lenz\contentfield\models\schemas;

use craft\web\twig\Environment;
use craft\web\View;
use Exception;
use lenz\contentfield\controllers\TemplatesController;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\values\ArrayValue;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\Plugin;
use lenz\contentfield\twig\YamlAwareTemplateLoader;
use Throwable;
use Twig\TemplateWrapper;

/**
 * Class TemplateSchema
 */
class TemplateSchema extends AbstractSchemaContainer
{
  /**
   * @var bool
   */
  public $inline;

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

    $action->controller = new TemplatesController('templates', $module, $config);
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function display(InstanceValue $instance, array $variables = []) {
    $this->getTemplate()->display(
      self::normalizedVariables($instance, $variables)
    );
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function render(InstanceValue $instance, array $variables = [], array $options = []) {
    $variables = self::normalizedVariables($instance, $variables);
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
      self::$_twig = YamlAwareTemplateLoader::getSiteTwig();
    }

    return self::$_twig;
  }

  /**
   * @param InstanceValue $instance
   * @param array $variables
   * @return array
   * @throws Exception
   */
  static function normalizedVariables(InstanceValue $instance, array $variables) {
    $variables = array_merge(
      [
        'editAttributes' => $instance->getEditAttributes(),
        'entry'          => $instance->getContent()->getOwner(),
        'instance'       => $instance,
        'isChunkRequest' => false,
        'model'          => $instance->getModel(),
      ],
      $instance->getValues(),
      $variables
    );

    if (!array_key_exists('loop', $variables)) {
      $variables['loop'] = ArrayValue::createLoopVariable(0, 1);
    }

    return $variables;
  }
}
