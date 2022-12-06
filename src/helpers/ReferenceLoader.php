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
  private array $_contents = [];

  /**
   * @var ElementInterface[][]
   */
  private array $_elements = [];

  /**
   * @var ReferenceMap
   */
  private ReferenceMap $_referenceMap;

  /**
   * @var int|null
   */
  private ?int $_siteId = null;


  /**
   * BatchLoader constructor.
   * @param Content|null $content
   */
  public function __construct(Content $content = null) {
    if (!is_null($content)) {
      $element = $content->getOwner();
      if ($element instanceof Element) {
        $this->_siteId = $element->siteId;
      }

      $this->_contents[] = $content;
    }
  }

  /**
   * @param Content $content
   * @throws Exception
   */
  public function addContent(Content $content): void {
    if (isset($this->_referenceMap)) {
      throw new Exception('This batch loader has already been used.');
    }

    $element = $content->getOwner();
    if ($element instanceof Element) {
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
   * @param int|null $siteId
   * @return ElementInterface|null
   */
  public function getElement(string $elementType, int $id, int $siteId = null): ?ElementInterface {
    $elements = $this->getElements($elementType, $siteId);

    return array_key_exists($id, $elements)
      ? $elements[$id]
      : null;
  }

  /**
   * @param string $elementType
   * @param int|null $siteId
   * @return ElementInterface[]
   */
  public function getElements(string $elementType, int $siteId = null): array {
    $cacheKey = ReferenceMap::key($elementType, $siteId);
    if (!(array_key_exists($cacheKey, $this->_elements))) {
      $result = [];
      $elements = $this->queryElements($elementType, $siteId);
      foreach ($elements as $element) {
        $result[intval($element->getId())] = $element;
      }

      $this->_elements[$cacheKey] = $result;
    }

    return $this->_elements[$cacheKey];
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
   * @param int|null $siteId
   * @return ElementInterface[]
   */
  private function queryElements(string $elementType, int $siteId = null): array {
    $referenceMap = $this->getReferenceMap();
    $ids = $referenceMap->getElementIds($elementType, $siteId);
    if (count($ids) === 0 || !class_exists($elementType)) {
      return [];
    }

    /** @var ElementInterface $elementType */
    $query = $elementType::find()
      ->id($ids)
      ->siteId($siteId ?: $this->_siteId);

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
