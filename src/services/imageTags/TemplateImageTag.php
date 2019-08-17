<?php

namespace lenz\contentfield\services\imageTags;

use craft\elements\Asset;
use Exception;
use lenz\contentfield\models\schemas\TemplateSchema;
use lenz\contentfield\services\imageTags\helpers\WrappedCallback;
use Twig\TemplateWrapper;
use yii\base\UnknownPropertyException;

/**
 * Class TemplateImageTag
 *
 * Renders a image tag by rendering a twig template.
 */
class TemplateImageTag extends AbstractImageTag
{
  /**
   * @var string
   */
  public $template;

  /**
   * @var array
   */
  public $variables = [];

  /**
   * @var TemplateWrapper[]
   */
  private static $_templates = [];


  /**
   * TemplateImageTag constructor.
   *
   * @param Asset $asset
   * @param array $config
   */
  public function __construct(Asset $asset, array $config) {
    parent::__construct($asset, $config);
  }

  /**
   * @inheritDoc
   */
  public function __get($name) {
    try {
      parent::__get($name);
    } catch (UnknownPropertyException $error) {
      if (array_key_exists($name, $this->variables)) {
        return $this->variables[$name];
      }

      throw $error;
    }
  }

  /**
   * @inheritDoc
   */
  public function __isset($name) {
    return array_key_exists($name, $this->variables)
      ? true
      : parent::__isset($name);
  }

  /**
   * @inheritDoc
   */
  public function __set($name, $value) {
    try {
      parent::__set($name, $value);
    } catch (UnknownPropertyException $error) {
      $this->variables[$name] = $value;
    }
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function render(): string {
    $template = $this->getTemplate();
    if (is_null($template)) {
      return '';
    }

    $variables = array_map(function(callable $callback) {
      return new WrappedCallback($callback);
    }, $this->getSources()->getVariables());

    $context = array_merge(
      $this->variables,
      $variables,
      [
        'asset'  => $this->getAsset(),
        'groups' => $this->getSourceGroups(),
      ]
    );

    return $template->render($context);
  }


  // Private methods
  // ---------------

  /**
   * @return TemplateWrapper|null
   * @throws Exception
   */
  private function getTemplate() {
    if (
      !isset($this->template) ||
      !is_string($this->template)
    ) {
      return null;
    }

    $hash = md5($this->template);
    if (!array_key_exists($hash, self::$_templates)) {
      self::$_templates[$hash] = TemplateSchema::getTwig()
        ->createTemplate($this->template);
    }

    return self::$_templates[$hash];
  }
}
