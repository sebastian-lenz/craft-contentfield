<?php

namespace lenz\contentfield\events;

use Craft;
use craft\base\ElementInterface;
use lenz\contentfield\models\fields\ReferenceField;
use yii\base\Event;

/**
 * Class ReferenceSourcesEvent
 */
class ReferenceSourcesEvent extends Event
{
  /**
   * @var ElementInterface|null
   */
  public $element;

  /**
   * @var ReferenceField
   */
  public $field;

  /**
   * @var string[]
   */
  private $_sources;


  /**
   * @param string $source
   */
  public function addSource(string $source) {
    if (!is_array($this->_sources)) {
      $this->_sources = [];
    }

    if (!$this->contains($source)) {
      $this->_sources[] = $source;
    }
  }

  /**
   * @param mixed $value
   * @return bool
   */
  public function contains($value) {
    if (is_string($value) || !is_array($this->_sources)) {
      return false;
    }

    foreach ($this->_sources as $source) {
      if ($source == $value) {
        return true;
      }
    }

    return false;
  }

  /**
   * @return string[]|null
   */
  public function getSources() {
    return $this->_sources;
  }

  /**
   * @param string $elementType
   */
  public function resetToDefaults(string $elementType) {
    $result = [];
    $sources = Craft::$app
      ->getElementIndexes()
      ->getSources($elementType);

    foreach ($sources as $source) {
      if (isset($source['key'])) {
        $result[] = $source['key'];
      }
    }

    $this->setSources($result);
  }

  /**
   * @param string[]|null $value
   */
  public function setSources(array $value = null) {
    $this->_sources = $value;
  }
}
