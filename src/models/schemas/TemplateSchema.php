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
      $instance->getValues(),
      $variables
    );

    try {
      return \Craft::$app->getView()->renderTemplate($this->template, $variables);
    } catch (\Exception $exception) {
      return '';
    }
  }
}
