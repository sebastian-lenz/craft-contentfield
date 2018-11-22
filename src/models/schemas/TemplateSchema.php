<?php

namespace contentfield\models\schemas;

use contentfield\models\values\InstanceValue;

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
   * @inheritdoc
   */
  public function render(InstanceValue $instance, array $variables = []) {
    $variables = array_merge(
      [
        'entry' => $instance->getContent()->getOwner(),
        'node' => $instance,
      ],
      $instance->getValues(),
      $variables
    );

    $view = \Craft::$app->getView();
    $oldTemplateMode = $view->getTemplateMode();
    if ($oldTemplateMode !== $view::TEMPLATE_MODE_SITE) {
      $view->setTemplateMode($view::TEMPLATE_MODE_SITE);
    }

    if (CRAFT_ENVIRONMENT === 'dev') {
      $result = $view->renderTemplate($this->template, $variables);
    } else {
      try {
        $result = $view->renderTemplate($this->template, $variables);
      } catch (\Exception $exception) {
        $result = '';
      }
    }

    if ($oldTemplateMode !== $view::TEMPLATE_MODE_SITE) {
      $view->setTemplateMode($oldTemplateMode);
    }

    return $result;
  }
}
