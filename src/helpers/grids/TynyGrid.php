<?php

namespace lenz\contentfield\helpers\grids;

use lenz\contentfield\models\fields\LayoutField;
use lenz\contentfield\models\values\LayoutColumnValue;

/**
 * Class TynyGrid
 */
class TynyGrid extends BootstrapGrid
{
  /**
   * @inheritDoc
   */
  public $rowClassName = 'row layout';


  /**
   * @inheritDoc
   */
  public function getClassName(LayoutColumnValue $column, string $attribute, int $value, string $breakpoint): string {
    $suffix = $breakpoint == 'xs' ? '' : "@$breakpoint";

    switch ($attribute) {
      case 'offset':
        if ($value == 0 && $breakpoint == 'xs') return '';
        return "offset-$value$suffix";
      case 'order':
        if ($value == 0) return "";
        if ($value < 1) $value = 'first';
        if ($value > $column->getField()->columnsPerRow) $value = 'last';
        return "order-$value$suffix";
      case 'width':
        if (empty($suffix) && $value == $column->getField()->columnsPerRow) return "";
        return "width-$value$suffix";
      default:
        return "";
    }
  }

  /**
   * @inheritDoc
   */
  public function parse(LayoutField $field, string $className): array {
    $result = [
      'class' => [],
      'offset' => [],
      'order' => [],
      'width' => [],
    ];

    foreach (preg_split('/\s+/', $className) as $className) {
      if (!preg_match('/^(offset|order|width)-([^@]+)(@(sm|md|lg|xl))?$/', $className, $match)) {
        $result['class'][] = $className;
        continue;
      }

      $attribute = $match[1];
      $value = $match[2];
      $breakpoint = empty($match[4]) ? 'xs' : $match[4];
      if ($attribute == 'order') {
        if ($value == 'first') $value = -1;
        if ($value == 'last') $value = $field->columnsPerRow + 1;
      }

      if (is_numeric($value)) {
        $result[$attribute][$breakpoint] = intval($value);
      } else {
        $result['class'][] = $className;
      }
    }

    return $field->normalizeBreakpointMaps($result);
  }
}
