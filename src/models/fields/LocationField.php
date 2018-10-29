<?php

namespace contentfield\models\fields;

use contentfield\models\values\ColorValue;
use contentfield\models\values\AbstractValue;
use contentfield\models\values\LocationValue;
use contentfield\utilities\DefaultLocations;
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
