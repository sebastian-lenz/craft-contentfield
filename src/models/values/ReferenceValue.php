<?php

namespace lenz\contentfield\models\values;

use ArrayAccess;
use ArrayIterator;
use Countable;
use craft\base\ElementInterface;
use craft\elements\Asset;
use craft\errors\SiteNotFoundException;
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
  private array $_references;

  /**
   * @var array<array{'id': int, 'siteId': null|int}>
   */
  private array $_values;


  /**
   * ReferenceValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface|null $parent
   * @param ReferenceField|null $field
   * @throws SiteNotFoundException
   */
  public function __construct($data, ValueInterface $parent = null, ReferenceField $field = null) {
    parent::__construct($parent, $field);

    if (!is_array($data)) {
      $this->_values = [];
    } else {
      $site = $this->_field->getTargetSite();
      $this->_values = array_filter(array_map(function($reference) use ($site) {
        if (is_numeric($reference)) {
          return ['id' => intval($reference), 'siteId' => $site?->id];
        } elseif (is_array($reference) && array_key_exists('id', $reference)) {
          if ($site) $reference['siteId'] = $site->id;
          return $reference;
        } else {
          return null;
        }
      }, $data));
    }
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function __toString(): string {
    return implode(', ', array_map(function($value) {
      return (string)$value;
    }, $this->getReferences()));
  }

  /**
   * Returns the first reference or null if no references are set.
   *
   * @return ElementInterface|null
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
    return array_map(fn($value) => $value['id'], $this->_values);
  }

  /**
   * @inheritdoc
   */
  public function getReferenceMap(ReferenceMap $map = null): ReferenceMap {
    $map = is_null($map) ? new ReferenceMap() : $map;
    $elementType = $this->_field->getElementType();
    $site = $this->_field->getTargetSite();

    foreach ($this->_values as $value) {
      $map->push($elementType, $value['id'], $site ? $site->id : $value['siteId']);
    }

    if (!empty($this->_field->with)) {
      $map->with($elementType, $this->_field->with);
    }

    if (!empty($this->_field->withTransforms)) {
      $map->withTransforms($this->_field->withTransforms);
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
   * @param array|string $config
   * @return Markup|null
   * @throws Exception
   * @noinspection PhpUnused
   */
  public function imageTag(array|string $config = 'default'): ?Markup {
    foreach ($this->getReferences() as $reference) {
      if ($reference instanceof Asset) {
        $result = Plugin::getInstance()
          ->imageTags
          ->render($reference, $config);

        if (!is_null($result)) {
          return Template::raw($result);
        }
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
  public function offsetGet($offset): ElementInterface {
    $references = $this->getReferences();
    return $references[$offset];
  }

  /**
   * @inheritdoc
   */
  public function offsetSet($offset, $value): void { }

  /**
   * @inheritdoc
   */
  public function offsetUnset($offset): void { }


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
  public function getIterator(): ArrayIterator {
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
    $site = $this->_field->getTargetSite();

    if (!$content) {
      return array_filter(array_map(
        fn(array $value) => $elementType::findOne($value),
        $this->_values
      ));
    }

    $loader = $content->getReferenceLoader();
    return array_values(array_filter(array_map(
      fn(array $value) => $loader->getElement($elementType, $value['id'], $site ? $site->id : $value['siteId']),
      $this->_values
    )));
  }
}
