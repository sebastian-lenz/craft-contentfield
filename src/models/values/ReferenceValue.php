<?php

namespace contentfield\models\values;

use contentfield\models\fields\ReferenceField;
use craft\base\ElementInterface;

/**
 * Class ReferenceValue
 *
 * @property ReferenceField $field
 */
class ReferenceValue extends AbstractValue implements \ArrayAccess, \Countable, \IteratorAggregate
{
  /**
   * @var ElementInterface[]
   */
  private $references;

  /**
   * @var int[]
   */
  private $values = array();


  /**
   * ReferenceValue constructor.
   *
   * @param mixed $data
   * @param AbstractValue $parent
   * @param ReferenceField $field
   */
  public function __construct($data, AbstractValue $parent, ReferenceField $field) {
    parent::__construct($parent, $field);

    if (!is_array($data)) {
      $this->values = array();
    } else {
      $this->values = array_filter($data, function($value) {
        return is_int($value);
      });
    }
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
    return implode('', array_map(function($value) {
      return (string)$value;
    }, $this->getReferences()));
  }

  /**
   * @inheritdoc
   */
  public function count() {
    $references = $this->getReferences();
    return count($references);
  }

  /**
   * @inheritdoc
   */
  public function getEagerLoadingMap(&$result = array()) {
    $elementType = $this->field->getElementType();
    if (!array_key_exists($elementType, $result)) {
      $result[$elementType] = array(
        'ids' => array(),
      );
    }

    foreach ($this->values as $value) {
      if (!in_array($value, $result[$elementType]['ids'])) {
        $result[$elementType]['ids'][] = $value;
      }
    }

    return $result;
  }

  /**
   * @return int[]
   */
  public function getEditorData() {
    return $this->values;
  }

  /**
   * @return \Twig_Markup
   */
  public function getHtml() {
    return new \Twig_Markup(implode('', array_map(function($value) {
      return (string)$value;
    }, $this->getReferences())), 'utf-8');
  }

  /**
   * @inheritdoc
   */
  public function getIterator() {
    return new \ArrayIterator($this->getReferences());
  }

  /**
   * @return ElementInterface[]
   */
  public function getReferences() {
    if (!isset($this->references)) {
      $this->references = $this->loadReferences();
    }

    return $this->references;
  }

  /**
   * @return ElementInterface[]
   */
  private function loadReferences() {
    $elementType = $this->field->getElementType();
    if (is_null($elementType) || count($this->values) === 0) {
      return array();
    }

    $content = $this->getContent();
    if (!is_null($content)) {
      $elements = $content->getEagerLoadedElements($elementType);
      $result = array();
      foreach ($this->values as $id) {
        if (array_key_exists($id, $elements)) {
          $result[] = $elements[$id];
        }
      }

      return $result;
    }

    /** @var ElementInterface $elementType */
    $result = array();
    $elements = $elementType::findAll(array(
      'id' => $this->values,
    ));

    foreach ($this->values as $id) {
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
   */
  public function offsetExists($offset) {
    $references = $this->getReferences();
    return array_key_exists($offset, $references);
  }

  /**
   * @inheritdoc
   */
  public function offsetGet($offset) {
    $references = $this->getReferences();
    return $references[$offset];
  }

  /**
   * @inheritdoc
   * @throws \Exception
   */
  public function offsetSet($offset, $value) { }

  /**
   * @inheritdoc
   * @throws \Exception
   */
  public function offsetUnset($offset) { }
}
