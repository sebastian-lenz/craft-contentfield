<?php

namespace lenz\contentfield\models\values;

use lenz\contentfield\models\fields\LocationField;

/**
 * Class LocationValue
 *
 * @property LocationField $_field
 */
class LocationValue extends Value
{
  /**
   * @var float
   */
  public $latitude = 0;

  /**
   * @var float
   */
  public $longitude = 0;


  /**
   * LocationValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface $parent
   * @param LocationField $field
   */
  public function __construct($data, ValueInterface $parent, LocationField $field) {
    parent::__construct($parent, $field);

    if (is_array($data)) {
      if (is_numeric($data['latitude'])) {
        $this->latitude = max(-90, min(90, $data['latitude']));
      }

      if (is_numeric($data['longitude'])) {
        $this->longitude = max(-180, min(180, $data['longitude']));
      }
    } else {
      $defaultValue = $field->getEditorDefaultValue($this->getElement());
      $this->latitude = $defaultValue['latitude'];
      $this->longitude = $defaultValue['longitude'];
    }
  }

  /**
   * @return string
   */
  function __toString() {
    return $this->latitude . '/' . $this->longitude;
  }


  /**
   * Returns the data of this value as required by the cp editor.
   * @return mixed
   */
  function getEditorData() {
    return array(
      'latitude'  => $this->latitude,
      'longitude' => $this->longitude,
    );
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return $this->latitude == 0 || $this->longitude == 0;
  }
}
