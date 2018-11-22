<?php

namespace contentfield\models\enumerations;

use contentfield\models\values\EnumerationValue;

/**
 * Class StaticEnumeration
 */
class StaticEnumeration implements EnumerationInterface
{
  /**
   * @var array
   */
  protected $options;


  /**
   * StaticEnumeration constructor.
   * @param array $options
   */
  public function __construct($options = array()) {
    if (is_string($options)) {
      $options = explode(',', $options);
      $options = array_map('trim', $options);
    }

    if (!is_array($options)) {
      $options = array();
    }

    $safeOptions = array();
    foreach ($options as $key => $value) {
      if (!is_array($value)) {
        $value = array(
          'key'   => $key,
          'label' => (string)$value,
        );
      }

      if (!isset($value['key'])) {
        $value['key'] = $key;
      }

      if (!isset($value['label'])) {
        $value['label'] = (string)$value['key'];
      }

      if (!EnumerationValue::isValidEnumerationKey($value['key'])) {
        \Craft::warning('Invalid enumeration key "%s", enumeration keys must be integers or strings');
        continue;
      }

      $keyExists = false;
      foreach ($safeOptions as $safeOption) {
        if ($safeOption['key'] === $value['key']) {
          $keyExists = true;
          break;
        }
      }

      if (!$keyExists) {
        $safeOptions[] = $value;
      }
    }

    $this->options = $safeOptions;
  }

  /**
   * @inheritdoc
   */
  function getOptions() {
    usort($this->options, function($left, $right) {
      return strcmp($left['label'], $right['label']);
    });

    return $this->options;
  }
}
