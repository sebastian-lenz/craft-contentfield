<?php

namespace lenz\contentfield\models\schemas;

use lenz\contentfield\models\values\InstanceValue;

/**
 * Class TemplateSchema
 */
class TemplateSchema extends AbstractSchema
{
  /**
   * @var string
   */
  public $path;

  /**
   * @var string
   */
  public $template;

  /**
   * @var \Twig\TemplateWrapper
   */
  private $_template;

  /**
   * @var \craft\web\twig\Environment
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
   * @return \Twig\TemplateWrapper
   * @throws \Throwable
   */
  private function getTemplate() {
    if (!isset($this->_template)) {
      $this->_template = self::getTwig()->load($this->template);
    }

    return $this->_template;
  }

  /**
   * @inheritdoc
   */
  public function render(InstanceValue $instance, array $variables = []) {
    return $this->getTemplate()->render(
      $this->getNormalizedVariables($instance, $variables)
    );
  }

  /**
   * @return \craft\web\twig\Environment
   * @throws \yii\base\Exception
   */
  static function getTwig() {
    if (!isset(self::$_twig)) {
      $view = \Craft::$app->getView();
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

  /**
   * @param InstanceValue $instance
   * @param array $variables
   * @return array
   */
  private function getNormalizedVariables(InstanceValue $instance, array $variables) {
    return array_merge(
      [
        'entry' => $instance->getContent()->getOwner(),
        'node' => $instance,
      ],
      $instance->getValues(),
      $variables
    );
  }
}
