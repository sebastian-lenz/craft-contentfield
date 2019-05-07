<?php

namespace lenz\contentfield\models;

use lenz\contentfield\events\RenderEvent;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\Plugin;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Model;
use craft\elements\db\AssetQuery;
use lenz\contentfield\utilities\ReferenceLoader;
use lenz\contentfield\utilities\twig\DisplayInterface;

/**
 * Class Content
 * @package contentfield\models
 */
class Content extends Model implements DisplayInterface
{
  /**
   * @var ReferenceLoader
   */
  private $batchLoader;

  /**
   * @var values\InstanceValue|null
   */
  private $model;

  /**
   * @var ElementInterface|null
   */
  private $owner;

  /**
   * Event triggered before some content is rendered.
   */
  const EVENT_BEFORE_RENDER = 'beforeRender';


  /**
   * Content constructor.
   *
   * @param values\InstanceValue|null $model
   * @param ElementInterface|null $element
   */
  public function __construct(
    values\InstanceValue $model = null,
    ElementInterface $element = null
  ) {
    $this->owner = $element;
    $this->setModel($model);

    parent::__construct();
  }

  /**
   * @return string
   */
  public function __toString() {
    return (string)$this->getHtml();
  }

  /**
   * @param array $variables
   */
  public function display(array $variables = []) {
    $model = $this->model;
    if (!is_null($model)) {
      $this->trigger(self::EVENT_BEFORE_RENDER, new RenderEvent([
        'content' => $this,
      ]));

      $model->display($variables);
    }
  }


  /**
   * @return ReferenceLoader
   */
  public function getBatchLoader() {
    if (!isset($this->batchLoader)) {
      $this->batchLoader = new ReferenceLoader($this);
    }

    return $this->batchLoader;
  }

  /**
   * @param array $variables
   * @return \Twig_Markup
   */
  public function getHtml(array $variables = []) {
    $model = $this->model;
    if (is_null($model)) {
      return new \Twig_Markup('', 'utf-8');
    }

    $this->trigger(self::EVENT_BEFORE_RENDER, new RenderEvent([
      'content' => $this,
    ]));

    return $model->getHtml($variables);
  }

  /**
   * @return values\InstanceValue|null
   */
  public function getModel() {
    return $this->model;
  }

  /**
   * @return ElementInterface|null
   */
  public function getOwner() {
    return $this->owner;
  }

  /**
   * @return \craft\models\Site
   */
  public function getOwnerSite() {
    if ($this->owner instanceof Element) {
      try {
        return $this->owner->getSite();
      } catch (\Exception $e) { }
    }

    return \Craft::$app->sites->currentSite;
  }

  /**
   * @return int[]
   */
  public function getReferencedIds() {
    $result = array();
    if (
      is_null($this->model) ||
      !($this->model instanceof values\InstanceValue)
    ) {
      return $result;
    }

    return array_map(function(ElementInterface $element) {
      return $element->getId();
    }, $this->model->getReferenceMap()->queryAll());
  }

  /**
   * @return string
   */
  public function getSearchKeywords() {
    return is_null($this->model)
      ? ''
      : $this->model->getSearchKeywords();
  }

  /**
   * @param ReferenceLoader $batchLoader
   * @throws \Exception
   */
  public function setBatchLoader(ReferenceLoader $batchLoader) {
    $batchLoader->addContent($this);
    $this->batchLoader = $batchLoader;
  }

  /**
   * @param InstanceValue|null $model
   */
  public function setModel(InstanceValue $model = null) {
    $this->model = $model;

    if (!is_null($model)) {
      $model->setContent($this);
    }
  }
}
