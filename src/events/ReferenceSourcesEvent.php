<?php

namespace lenz\contentfield\events;

use Craft;

/**
 * Class ReferenceSourcesEvent
 * @extends AbstractSourcesEvent<string, string|null>
 */
class ReferenceSourcesEvent extends AbstractSourcesEvent
{
  /**
   * @inheritDoc
   */
  public function getSources(): ?array {
    return empty($this->_values) ? null : $this->_values;
  }

  /**
   * @param string $elementType
   * @noinspection PhpUnused
   */
  public function setToDefaults(string $elementType): void {
    $sources = Craft::$app
      ->getElementSources()
      ->getSources($elementType);

    $this->_values = array_filter(
      array_map(fn($source) => $source['key'] ?? null, $sources)
    );
  }


  // Protected methods
  // -----------------

  /**
   * @inheritDoc
   */
  protected function isEqual(mixed $lft, mixed $rgt): bool {
    return $lft === $rgt;
  }

  /**
   * @inheritDoc
   */
  protected function toValue(mixed $value): ?string {
    return is_string($value) ? $value : null;
  }
}
