<?php

namespace lenz\contentfield\models\values;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Exception;
use IteratorAggregate;
use lenz\contentfield\models\fields\ReferenceField;
use lenz\contentfield\models\ReferenceMapValueInterface;
use lenz\contentfield\Plugin;
use craft\base\ElementInterface;
use craft\elements\Asset;
use craft\helpers\Template;
use lenz\contentfield\utilities\ReferenceMap;
use Twig\Markup;

/**
 * Class ReferenceValue
 *
 * @property ReferenceField $_field
 */
class ReferenceValue extends Value implements
  ArrayAccess,
  Countable,
  IteratorAggregate,
  ReferenceMapValueInterface
{
  /**
   * @var ElementInterface[]
   */
  private $_references;

  /**
   * @var int[]
   */
  private $_values = array();


  /**
   * ReferenceValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface $parent
   * @param ReferenceField $field
   */
  public function __construct($data, ValueInterface $parent, ReferenceField $field) {
    parent::__construct($parent, $field);

    if (!is_array($data)) {
      $this->_values = array();
    } else {
      $this->_values = array_filter($data, function($value) {
        return is_int($value);
      });
    }
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function __toString() {
    return implode('', array_map(function($value) {
      return (string)$value;
    }, $this->getReferences()));
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function count() {
    $references = $this->getReferences();
    return count($references);
  }

  /**
   * @return ElementInterface
   * @throws Exception
   */
  public function getFirst() {
    $references = $this->getReferences();
    return isset($references[0]) ? $references[0] : null;
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function getIterator() {
    return new ArrayIterator($this->getReferences());
  }

  /**
   * @return int[]
   */
  public function getReferencedIds() {
    return $this->_values;
  }

  /**
   * @inheritdoc
   */
  public function getReferenceMap(ReferenceMap $map = null) {
    if (is_null($map)) {
      $map = new ReferenceMap();
    }

    $elementType = $this->_field->getElementType();
    foreach ($this->_values as $value) {
      $map->push($elementType, $value);
    }

    if (isset($this->_field->with)) {
      $map->with($elementType, $this->_field->with);
    }

    return $map;
  }

  /**
   * @return ElementInterface[]
   * @throws Exception
   */
  public function getReferences() {
    if (!isset($this->_references)) {
      $this->_references = $this->loadReferences();
    }

    return $this->_references;
  }

  /**
   * @param string|array $config
   * @param array|null $extraConfig
   * @return Markup|Markup|null
   * @throws Exception
   */
  public function imageTag($config = 'default', $extraConfig = null) {
    foreach ($this->getReferences() as $reference) {
      if ($reference instanceof Asset) {
        $result = Plugin::getInstance()
          ->imageTags
          ->render($reference, $config, $extraConfig);

        return is_null($result)
          ? null
          : Template::raw($result);
      }
    }

    return null;
  }

  /**
   * @return bool
   * @throws Exception
   */
  public function isEmpty() {
    return $this->count() == 0;
  }

  /**
   * @return ElementInterface[]
   * @throws Exception
   */
  private function loadReferences() {
    $elementType = $this->_field->getElementType();
    if (is_null($elementType) || count($this->_values) === 0) {
      return array();
    }

    $content = $this->getContent();
    if (!is_null($content)) {
      $elements = $content->getReferenceLoader()->getElements($elementType);
      $result = array();

      foreach ($this->_values as $id) {
        if (array_key_exists($id, $elements)) {
          $result[] = $elements[$id];
        }
      }

      return $result;
    }

    /** @var ElementInterface $elementType */
    $result = array();
    $elements = $elementType::findAll(array(
      'id' => $this->_values,
    ));

    foreach ($this->_values as $id) {
      foreach ($elements as $element) {
        if ($element->getId() === $id) {
          $result[] = $element;
          break;
        }
      }
    }

    return $result;
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function offsetExists($offset) {
    $references = $this->getReferences();
    return array_key_exists($offset, $references);
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function offsetGet($offset) {
    $references = $this->getReferences();
    return $references[$offset];
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function offsetSet($offset, $value) { }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function offsetUnset($offset) { }
}
