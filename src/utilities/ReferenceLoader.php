<?php

namespace sebastianlenz\contentfield\utilities;

use craft\base\ElementInterface;
use craft\elements\db\AssetQuery;
use sebastianlenz\contentfield\models\Content;
use sebastianlenz\contentfield\Plugin;

/**
 * Class BatchLoader
 */
class ReferenceLoader
{
  /**
   * @var Content[]
   */
  private $contents = [];

  /**
   * @var ElementInterface[][]
   */
  private $elements = [];

  /**
   * @var ReferenceMap
   */
  private $referenceMap;


  /**
   * BatchLoader constructor.
   * @param Content|null $content
   */
  public function __construct(Content $content = null) {
    if (!is_null($content)) {
      $this->contents[] = $content;
    }
  }

  /**
   * @param Content $content
   * @throws \Exception
   */
  public function addContent(Content $content) {
    if (isset($this->referenceMap)) {
      throw new \Exception('This batch loader is already in used');
    }

    if (!in_array($content, $this->contents)) {
      $this->contents[] = $content;
    }
  }

  /**
   * @param string $elementType
   * @param int $id
   * @return ElementInterface|null
   */
  public function getElement($elementType, $id) {
    $elements = $this->getElements($elementType);

    return array_key_exists($id, $elements)
      ? $elements[$id]
      : null;
  }

  /**
   * @param string $elementType
   * @return ElementInterface[]
   */
  public function getElements($elementType) {
    if (!(array_key_exists($elementType, $this->elements))) {
      $result = array();
      $elements = $this->queryElements($elementType);
      foreach ($elements as $element) {
        $result[intval($element->getId())] = $element;
      }

      $this->elements[$elementType] = $result;
    }

    return $this->elements[$elementType];
  }


  // Private

  /**
   * @return ReferenceMap
   */
  private function getReferenceMap() {
    if (!isset($this->referenceMap)) {
      $referenceMap = new ReferenceMap();

      foreach ($this->contents as $content) {
        $model = $content->getModel();
        if (!is_null($model)) {
          $model->getReferenceMap($referenceMap);
        }
      }

      $this->referenceMap = $referenceMap;
    }

    return $this->referenceMap;
  }


  /**
   * @param string $elementType
   * @return ElementInterface[]
   */
  private function queryElements($elementType) {
    $referenceMap = $this->getReferenceMap();
    $ids = $referenceMap->getElementIds($elementType);
    if (count($ids) === 0) {
      return array();
    }

    /** @var ElementInterface $elementType */
    $query = $elementType::find()->id($ids);
    if ($query instanceof AssetQuery) {
      $transforms = Plugin::getInstance()->imageTags->getAllTransforms();
      if (count($transforms)) {
        $query->withTransforms($transforms);
      }
    }

    return $query->all();
  }
}
