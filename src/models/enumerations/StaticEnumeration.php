<?php

namespace lenz\contentfield\models\enumerations;

use Craft;
use lenz\contentfield\models\values\EnumerationValue;
use lenz\contentfield\Plugin;
use yii\helpers\Inflector;

/**
 * Class StaticEnumeration
 */
class StaticEnumeration implements CustomDataInterface, EnumerationInterface
{
  /**
   * @var array
   */
  protected $_options;


  /**
   * StaticEnumeration constructor.
   * @param array|string $options
   */
  public function __construct($options = []) {
    if (is_string($options)) {
      $options = explode(',', $options);
      $options = array_map('trim', $options);
    }

    if (!is_array($options)) {
      $options = [];
    }

    $safeOptions = [];
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
   * @inheritDoc
   */
  public function getCustomData($key, string $name) {
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
   * @return array
   */
  public function getOptionKeys(): array {
    return array_map(function(array $option) {
      return $option['key'];
    }, $this->_options);
  }

  /**
   * @inheritdoc
   */
  public function getOptions(): array {
    $options = $this->_options;
    $count   = count($options);

    for ($index = 0; $index < $count; $index++) {
      $options[$index]['label'] = Plugin::t($options[$index]['label']);
    }

    usort($options, function($left, $right) {
      return strcmp($left['label'], $right['label']);
    });

    return $options;
  }

  /**
   * @return array
   */
  public function getRawOptions(): array {
    return $this->_options;
  }

  /**
   * @inheritDoc
   */
  public function hasCustomData($key, string $name): bool {
    foreach ($this->_options as $option) {
      if ($option['key'] === $key) {
        return array_key_exists($name, $option);
      }
    }

    return false;
  }
}
