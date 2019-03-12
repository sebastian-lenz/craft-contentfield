<?php

namespace sebastianlenz\contentfield\models\fields;

use sebastianlenz\contentfield\models\values\ColorValue;
use sebastianlenz\contentfield\models\values\AbstractValue;
use sebastianlenz\contentfield\models\values\LocationValue;
use sebastianlenz\contentfield\utilities\DefaultLocations;
use craft\base\ElementInterface;

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
  public function createValue($data, AbstractValue $parent) {
    return new LocationValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + array(
    );
  }

  /**
   * @inheritdoc
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

    return DefaultLocations::get($element);
  }
}
