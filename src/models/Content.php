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
   * @param array|null $elementData
   * @return ElementInterface[]
   */
  public function getEagerLoadedElements($elementType, $elementData = null) {
    if (!(array_key_exists($elementType, $this->eagerLoadedElements))) {
      $result = array();
      $elements = $this->eagerLoad($elementType, $elementData);
      foreach ($elements as $element) {
        $result[intval($element->getId())] = $element;
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
   * @return int[]
   */
  public function getReferencedIds() {
    $result = array();
    $elementTypes = $this->model->getEagerLoadingMap();

    /** @var ElementInterface $elementType */
    foreach ($elementTypes as $elementType => $elementData) {
      $elements = $this->getEagerLoadedElements($elementType, $elementData);

      foreach ($elements as $id => $element) {
        if (!in_array($id, $result)) {
          $result[] = $id;
        }
      }
    }

    return $result;
  }

  /**
   * @param string $elementType
   * @param array|null $elementData
   * @return ElementInterface[]
   */
  private function eagerLoad($elementType, $elementData = null) {
    if (is_null($this->model)) {
      return array();
    }

    if (!is_array($elementData)) {
      $map = $this->model->getEagerLoadingMap();
      if (!array_key_exists($elementType, $map)) {
        return array();
      }

      $elementData = $map[$elementType];
    }

    if (
      !isset($elementData['ids']) ||
      !is_array($elementData['ids']) ||
      count($elementData['ids']) === 0
    ) {
      return array();
    }

    /** @var ElementInterface $elementType */
    return $elementType::find()
      ->id($elementData['ids'])
      ->all();
  }
}
