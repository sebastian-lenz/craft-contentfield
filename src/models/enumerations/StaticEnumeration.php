<?php

namespace lenz\contentfield\models\enumerations;

use Craft;
use lenz\contentfield\models\values\EnumerationValue;
use lenz\contentfield\Plugin;
use yii\helpers\Inflector;

/**
 * Class StaticEnumeration
 */
class StaticEnumeration implements EnumerationInterface
{
  /**
   * @var array
   */
  protected $_options;


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
        if (is_numeric($key)) {
          $value = [
            'key'   => $value,
            'label' => Inflector::camel2words((string)$value, true),
          ];
        } else {
          $value = [
            'key'   => $key,
            'label' => $value,
          ];
        }
      }

      if (!isset($value['key'])) {
        $value['key'] = is_numeric($key) ? $value : $key;
      }

      if (!isset($value['label'])) {
        $value['label'] = (string)$value['key'];
      }

      if (!EnumerationValue::isValidEnumerationKey($value['key'])) {
        Craft::warning('Invalid enumeration key "%s", enumeration keys must be integers or strings');
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

    $this->_options = $safeOptions;
  }

  /**
   * @param string|int $key
   * @param string $name
   * @return mixed
   */
  function getCustomData($key, $name) {
    foreach ($this->_options as $option) {
      if ($option['key'] === $key) {
        return array_key_exists($name, $option)
          ? $option[$name]
          : null;
      }
    }

    return null;
  }

  /**
   * @inheritdoc
   */
  function getOptions() {
    $options = $this->_options;
    for ($index = 0; $index < count($options); $index++) {
      $options[$index]['label'] = Plugin::t($options[$index]['label']);
    }

    usort($options, function($left, $right) {
      return strcmp($left['label'], $right['label']);
    });

    return $options;
  }
}
