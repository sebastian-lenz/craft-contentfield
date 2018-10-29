<?php

namespace contentfield\models\values;

use contentfield\models\fields\LocationField;

/**
 * Class LocationValue
 *
 * @property LocationField $field
 */
class LocationValue extends AbstractValue
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
   * @param AbstractValue $parent
   * @param LocationField $field
   */
  public function __construct($data, AbstractValue $parent, LocationField $field) {
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
   * @return \Twig_Markup
   */
  function getHtml() {
    return new \Twig_Markup((string)$this, 'utf-8');
  }
}
