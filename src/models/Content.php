<?php

namespace contentfield\models;

use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Model;

/**
 * Class Content
 * @package contentfield\models
 */
class Content extends Model
{
  /**
   * @var values\InstanceValue|null
   */
  public $model;

  /**
   * @var ElementInterface[][]
   */
  private $eagerLoadedElements = array();

  /**
   * @var ElementInterface|null
   */
  private $owner;


  /**
   * Link constructor.
   * @param array $config
   */
  public function __construct($config = []) {
    $this->owner = $config['owner'];
    unset($config['owner']);

    parent::__construct($config);
  }

  /**
   * @return string
   */
  public function __toString() {
    return is_null($this->model)
      ? ''
      : (string)$this->model;
  }

  /**
   * @param string $elementType
   * @param int $id
   * @return ElementInterface|null
   */
  public function getEagerLoadedElement($elementType, $id) {
    $elements = $this->getEagerLoadedElements($elementType);
    return array_key_exists($id, $elements)
      ? $elements[$id]
      : null;
  }

  /**
   * @param string $elementType
   * @return ElementInterface[]
   */
  public function getEagerLoadedElements($elementType) {
    if (!(array_key_exists($elementType, $this->eagerLoadedElements))) {
      $result = array();
      $elements = $this->eagerLoad($elementType);
      foreach ($elements as $element) {
        $result[$element->getId()] = $element;
      }

      $this->eagerLoadedElements[$elementType] = $result;
    }

    return $this->eagerLoadedElements[$elementType];
  }

  /**
   * @return \Twig_Markup
   */
  public function getHtml() {
    return is_null($this->model)
      ? new \Twig_Markup('', 'utf-8')
      : $this->model->getHtml();
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
   * @param string $elementType
   * @return ElementInterface[]
   */
  private function eagerLoad($elementType) {
    if (is_null($this->model)) {
      return array();
    }

    $map = $this->model->getEagerLoadingMap();
    if (!array_key_exists($elementType, $map) || count($map[$elementType]['ids']) === 0) {
      return array();
    }

    /** @var ElementInterface $elementType */
    return $elementType::find()
      ->id($map[$elementType]['ids'])
      ->all();
  }
}
