<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use lenz\contentfield\helpers\DefaultGeoLocations;
use lenz\contentfield\models\values\LocationValue;
use lenz\contentfield\models\values\ValueInterface;

/**
 * Class LocationField
 */
class LocationField extends AbstractField
{
  /**
   * @var array
   */
  public array $defaultValue;

  /**
   * @inheritdoc
   */
  const NAME = 'location';


  /**
   * @inheritdoc
   */
  public function createValue(mixed $data, ValueInterface $parent = null): LocationValue {
    return new LocationValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null): array {
    return parent::getEditorData($element) + [
      'defaultValue' => $this->getEditorDefaultValue($element),
    ];
  }

  /**
   * @param ElementInterface|null $element
   * @return float[]
   */
  public function getEditorDefaultValue(ElementInterface $element = null): array {
    $defaultValue = $this->defaultValue;

    if (
      is_float($defaultValue['latitude']) &&
      is_float($defaultValue['longitude'])
    ) {
      return array(
        'latitude' => $defaultValue['latitude'],
        'longitude' => $defaultValue['longitude'],
      );
    }

    return DefaultGeoLocations::get($element);
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue(mixed $value): ?array {
    if (!($value instanceof LocationValue)) {
      return null;
    }

    return array(
      'latitude'  => $value->latitude,
      'longitude' => $value->longitude,
    );
  }
}
