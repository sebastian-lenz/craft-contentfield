<?php

namespace lenz\contentfield\events;

use craft\base\ElementInterface;
use lenz\contentfield\models\fields\ReferenceField;
use yii\base\Event;

/**
 * Class AbstractSourcesEvent
 * @template TValue
 * @template TInput
 */
abstract class AbstractSourcesEvent extends Event
{
  /**
   * @var ElementInterface|null
   */
  public ?ElementInterface $element;

  /**
   * @var ReferenceField
   */
  public ReferenceField $field;

  /**
   * @var TValue[]
   */
  protected array $_values = [];


  /**
   * @param TInput $value
   * @return void
   */
  public function add(mixed $value): void {
    $value = $this->toValue($value);
    if (!is_null($value) && !$this->contains($value)) {
      $this->_values[] = $value;
    }
  }

  /**
   * @param TInput $value
   * @return bool
   */
  public function contains(mixed $value): bool {
    $value = $this->toValue($value);
    if (is_null($value)) {
      return false;
    }

    foreach ($this->_values as $existing) {
      if ($this->isEqual($value, $existing)) {
        return true;
      }
    }

    return false;
  }

  /**
   * @return string[]|null
   */
  abstract public function getSources(): ?array;

  /**
   * @param mixed $value
   * @return void
   */
  public function remove(mixed $value): void {
    $value = $this->toValue($value);
    if (is_null($value)) {
      return;
    }

    array_filter($this->_values, fn($existing) => !$this->isEqual($existing, $value));
  }

  /**
   * @return void
   */
  public function removeAll(): void {
    $this->_values = [];
  }

  /**
   * @param TInput[]|null $values
   * @noinspection PhpUnused
   */
  public function setSources(array $values = null): void {
    $this->removeAll();

    if (is_array($values)) {
      foreach ($values as $value) $this->add($value);
    }
  }


  // Protected methods
  // -----------------

  /**
   * @param TValue $lft
   * @param TValue $rgt
   * @return bool
   */
  abstract protected function isEqual(mixed $lft, mixed $rgt): bool;

  /**
   * @param TInput $value
   * @return TValue|null
   */
  abstract protected function toValue(mixed $value): mixed;
}
