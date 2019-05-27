<?php

namespace lenz\contentfield\models\schemas;

use Craft;
use craft\web\twig\Environment;
use lenz\contentfield\models\values\InstanceValue;
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
   * @inheritdoc
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
   */
  public function render(InstanceValue $instance, array $variables = []) {
    return $this->getTemplate()->render(
      $this->getNormalizedVariables($instance, $variables)
    );
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
      $view = Craft::$app->getView();
      $oldTemplateMode = $view->getTemplateMode();
      if ($oldTemplateMode !== $view::TEMPLATE_MODE_SITE) {
        $view->setTemplateMode($view::TEMPLATE_MODE_SITE);
      }

      self::$_twig = $view->getTwig();

      if ($oldTemplateMode !== $view::TEMPLATE_MODE_SITE) {
        $view->setTemplateMode($oldTemplateMode);
      }
    }

    return self::$_twig;
  }
}
