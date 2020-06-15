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
  public $defaultValue;

  /**
   * @inheritdoc
   */
  const NAME = 'location';


  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent = null) {
    return new LocationValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + array(
      'defaultValue' => $this->getEditorDefaultValue($element),
    );
  }

  /**
   * @param ElementInterface|null $element
   * @return array|float[]
   */
  public function getEditorDefaultValue(ElementInterface $element = null) {
    $defaultValue = $this->defaultValue;

    if (
      is_array($defaultValue) &&
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
  public function getEditorValue($value) {
    if (!($value instanceof LocationValue)) {
      return null;
    }

    return array(
      'latitude'  => $value->latitude,
      'longitude' => $value->longitude,
    );
  }
}
