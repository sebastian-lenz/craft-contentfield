<?php

namespace lenz\contentfield\services\anchors;

use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\models\values\ReferenceValue;

/**
 * Class Parser
 */
class Parser
{
  /** @var string */
  public static string $DISABLED_VALUE = '#NULL';


  /**
   * @param mixed $values
   * @param string $mode
   * @return string[]
   */
  static function parse(mixed $values, string $mode): array {
    if (empty($values)) {
      return [];
    }

    $values = array_filter(array_map('trim',
      is_array($values) ? $values : explode(',', $values)
    ));

    return match ($mode) {
      'delegates' => array_filter(array_map(
        fn(string $value) => str_starts_with($value, '...')
          ? array_filter(array_map('trim', explode('.', substr($value, 3))))
          : null,
        $values
      )),
      'fields' => array_filter(
        $values,
        fn(string $value) => !str_starts_with($value, '...')
      ),
      default => $values,
    };
  }

  /**
   * @return AnchorInterface[]
   */
  static function parseDelegates(InstanceValue $instance): array {
    $fields = self::parse($instance->getSchema()->anchor, 'delegates');
    $anchors = [];

    foreach ($fields as $field) {
      $value = $instance->offsetGet($field[0]);
      if (!($value instanceof ReferenceValue)) {
        continue;
      }

      foreach ($value->getReferences() as $element) {
        $model = $element->{$field[1]}->getModel();
        $anchors = array_merge($anchors, $model->getAllAnchors());
      }
    }

    return $anchors;
  }

  /**
   * @param InstanceValue $instance
   * @return InstanceAnchor|null
   */
  static function parseFields(InstanceValue $instance): ?InstanceAnchor {
    $fields = Parser::parse($instance->getSchema()->anchor, 'fields');

    foreach ($fields as $field) {
      $rawValue = $instance->offsetGet($field);

      if (is_bool($rawValue)) {
        if (!$rawValue) {
          return null;
        } else {
          continue;
        }
      }

      $value = trim((string)$rawValue);
      if ($value === self::$DISABLED_VALUE) {
        return null;
      }

      if (!empty($value)) {
        return new InstanceAnchor($instance->getUuid(), $value);
      }
    }

    return null;
  }
}
