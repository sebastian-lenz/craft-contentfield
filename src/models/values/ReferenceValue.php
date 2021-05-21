<?php

namespace lenz\contentfield\models\values;

use ArrayAccess;
use ArrayIterator;
use Countable;
use craft\base\ElementInterface;
use craft\elements\Asset;
use craft\helpers\Template;
use Exception;
use IteratorAggregate;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\helpers\ReferenceMappableInterface;
use lenz\contentfield\models\fields\ReferenceField;
use lenz\contentfield\Plugin;
use Twig\Markup;

/**
 * Class ReferenceValue
 *
 * @property ReferenceField $_field
 */
class ReferenceValue
  extends AbstractValue
  implements ArrayAccess, Countable, IteratorAggregate, ReferenceMappableInterface
{
  /**
   * @var ElementInterface[]
   */
  private $_references;

  /**
   * @var int[]
   */
  private $_values;


  /**
   * ReferenceValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface|null $parent
   * @param ReferenceField|null $field
   */
  public function __construct($data, ValueInterface $parent = null, ReferenceField $field = null) {
    parent::__construct($parent, $field);

    if (!is_array($data)) {
      $this->_values = [];
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
    return implode(', ', array_map(function($value) {
      return (string)$value;
    }, $this->getReferences()));
  }

  /**
   * Returns the first reference or null if no references are set.
   *
   * @return ElementInterface
   * @throws Exception
   */
  public function getFirst(): ?ElementInterface {
    $references = $this->getReferences();
    return $references[0] ?? null;
  }

  /**
   * Returns a list with all ids of the references elements.
   *
   * @return int[]
   * @noinspection PhpUnused (Public API)
   */
  public function getReferencedIds(): array {
    return $this->_values;
  }

  /**
   * @inheritdoc
   */
  public function getReferenceMap(ReferenceMap $map = null): ReferenceMap {
    $map = is_null($map) ? new ReferenceMap() : $map;
    $elementType = $this->_field->getElementType();
    foreach ($this->_values as $value) {
      $map->push($elementType, $value);
    }

    if (!empty($this->_field->with)) {
      $map->with($elementType, $this->_field->with);
    }

    return $map;
  }

  /**
   * Returns a list of referenced elements.
   *
   * @return ElementInterface[]
   * @throws Exception
   */
  public function getReferences(): array {
    if (!isset($this->_references)) {
      $this->_references = $this->loadReferences();
    }

    return $this->_references;
  }

  /**
   * Renders an image tag for the first reference in the field.
   *
   * @param string|array $config
   * @return Markup|null
   * @throws Exception
   */
  public function imageTag($config = 'default'): ?Markup {
    foreach ($this->getReferences() as $reference) {
      if ($reference instanceof Asset) {
        $result = Plugin::getInstance()
          ->imageTags
          ->render($reference, $config);

        return is_null($result)
          ? null
          : Template::raw($result);
      }
    }

    return null;
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function isEmpty(): bool {
    return $this->count() == 0;
  }


  // ArrayAccess
  // -----------

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function offsetExists($offset): bool {
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
   */
  public function offsetSet($offset, $value) { }

  /**
   * @inheritdoc
   */
  public function offsetUnset($offset) { }


  // Countable
  // ---------

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function count(): int {
    $references = $this->getReferences();
    return count($references);
  }


  // IteratorAggregate
  // -----------------

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function getIterator() {
    return new ArrayIterator($this->getReferences());
  }


  // Private methods
  // ---------------

  /**
   * @return ElementInterface[]
   * @throws Exception
   */
  private function loadReferences(): array {
    $elementType = $this->_field->getElementType();
    if (is_null($elementType) || count($this->_values) === 0) {
      return [];
    }

    $content = $this->getContent();
    if (!is_null($content)) {
      $elements = $content->getReferenceLoader()->getElements($elementType);
      $result = [];

      foreach ($this->_values as $id) {
        if (array_key_exists($id, $elements)) {
          $result[] = $elements[$id];
        }
      }

      return $result;
    }

    /** @var ElementInterface $elementType */
    $result = [];
    $elements = $elementType::findAll([
      'id' => $this->_values,
    ]);

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
}
