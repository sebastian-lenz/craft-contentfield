<?php

namespace lenz\contentfield\models\schemas;

use Craft;
use craft\web\twig\Environment;
use craft\web\View;
use Exception;
use lenz\contentfield\controllers\TemplatesController;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\helpers\loops\StaticLoop;
use lenz\contentfield\models\Content;
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
   * Whether this template should be inlined or not.
   *
   * @var bool
   */
  public bool $inline;

  /**
   * The complete filesystem path to this template, e.g.
   * `/var/www/html/templates/_elements/text.twig`.
   *
   * @var string
   */
  public string $path;

  /**
   * The name of this template, unlike the `path` this does not include
   * the path to the template folder, e.g. `_elements/text.twig`.
   *
   * @var string
   */
  public string $template;

  /**
   * The loaded template instance.
   *
   * @var TemplateWrapper
   */
  private TemplateWrapper $_template;

  /**
   * The global template variables, those will be available in all templates.
   *
   * @var array
   */
  static private array $_globalVariables;

  /**
   * The site twig instance we use to render templates.
   *
   * @var Environment
   */
  static private Environment $_twig;


  /**
   * @inheritDoc
   */
  public function applyPageTemplate(BeforeActionEvent $event, Content $content): void {
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
  public function display(InstanceValue $instance, array $variables = []): void {
    $this->getTemplate()->display(
      self::normalizedVariables($instance, $variables)
    );
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function render(InstanceValue $instance, array $variables = [], array $options = []): string {
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
  private function getTemplate(): TemplateWrapper {
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
  static function getTwig(): Environment {
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
  static function normalizedVariables(InstanceValue $instance, array $variables): array {
    if (!isset(self::$_globalVariables)) {
      $routeParams = Craft::$app
        ->getUrlManager()
        ->getRouteParams();

      $routeVariables = array_key_exists('variables', $routeParams)
        ? $routeParams['variables'] : [];

      self::$_globalVariables = $routeVariables + [
        'loop'           => StaticLoop::getInstance(),
        'isChunkRequest' => false,
      ];
    }

    $instanceVariables = [
      'editAttributes' => $instance->getEditAttributes(),
      'instance'       => $instance,
      'model'          => $instance->getModel(),
    ];

    $ownerVariable = Plugin::getInstance()->getSettings()->ownerVariable;
    if (!empty($ownerVariable)) {
      $instanceVariables[$ownerVariable] = $instance->getContent()->getOwner();
    }

    return array_merge(
      self::$_globalVariables,
      $instance->getSchema()->constants,
      $instanceVariables,
      $instance->getValues(),
      $variables
    );
  }
}
