<?php

namespace lenz\contentfield\helpers;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\elements\db\AssetQuery;
use Exception;
use lenz\contentfield\models\Content;
use lenz\contentfield\Plugin;

/**
 * Class ReferenceLoader
 */
class ReferenceLoader
{
  /**
   * @var Content[]
   */
  private $_contents = [];

  /**
   * @var ElementInterface[][]
   */
  private $_elements = [];

  /**
   * @var ReferenceMap
   */
  private $_referenceMap;

  /**
   * @var int|null
   */
  private $_siteId = null;


  /**
   * BatchLoader constructor.
   * @param Content|null $content
   * @throws Exception
   */
  public function __construct(Content $content = null) {
    if (!is_null($content)) {
      $this->addContent($content);
    }
  }

  /**
   * @param Content $content
   * @throws Exception
   */
  public function addContent(Content $content) {
    if (isset($this->_referenceMap)) {
      throw new Exception('This batch loader is already in used');
    }

    $element = $content->getOwner();
    if (!is_null($element) && $element instanceof Element) {
      if (is_null($this->_siteId)) {
        $this->_siteId = $element->siteId;
      } else if ($this->_siteId !== $element->siteId) {
        throw new Exception('Site ID mismatch, all contents added to the reference loader must be from the same site.');
      }
    }

    if (!in_array($content, $this->_contents, true)) {
      $this->_contents[] = $content;
    }
  }

  /**
   * @param string $elementType
   * @param int $id
   * @return ElementInterface|null
   */
  public function getElement(string $elementType, int $id): ?ElementInterface {
    $elements = $this->getElements($elementType);

    return array_key_exists($id, $elements)
      ? $elements[$id]
      : null;
  }

  /**
   * @param string $elementType
   * @return ElementInterface[]
   */
  public function getElements(string $elementType): array {
    if (!(array_key_exists($elementType, $this->_elements))) {
      $result = [];
      $elements = $this->queryElements($elementType);
      foreach ($elements as $element) {
        $result[intval($element->getId())] = $element;
      }

      $this->_elements[$elementType] = $result;
    }

    return $this->_elements[$elementType];
  }


  // Private methods
  // ---------------

  /**
   * @return ReferenceMap
   */
  private function getReferenceMap(): ReferenceMap {
    if (!isset($this->_referenceMap)) {
      $referenceMap = new ReferenceMap();

      foreach ($this->_contents as $content) {
        $model = $content->getModel();
        if (!is_null($model)) {
          $model->getReferenceMap($referenceMap);
        }
      }

      $this->_referenceMap = $referenceMap;
    }

    return $this->_referenceMap;
  }

  /**
   * @param string $elementType
   * @return ElementInterface[]
   */
  private function queryElements(string $elementType): array {
    $referenceMap = $this->getReferenceMap();
    $ids = $referenceMap->getElementIds($elementType);
    if (count($ids) === 0 || !class_exists($elementType)) {
      return [];
    }

    /** @var ElementInterface $elementType */
    $query = $elementType::find()
      ->id($ids)
      ->siteId($this->_siteId);

    if ($referenceMap->hasWith($elementType)) {
      $query->with($referenceMap->getWith($elementType));
    }

    // Within the control panel we'll ignore statuses
    if (Craft::$app->getRequest()->getIsCpRequest()) {
      $query->status(null);
    }

    if ($query instanceof AssetQuery) {
      $transforms = array_unique(array_merge(
        Plugin::getInstance()->imageTags->getAllTransforms(),
        $referenceMap->getWithTransforms()
      ));

      if (count($transforms)) {
        $query->withTransforms($transforms);
      }
    }

    return $query->all();
  }
}
