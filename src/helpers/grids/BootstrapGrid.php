<?php

namespace lenz\contentfield\helpers\grids;

use craft\helpers\Html;
use lenz\contentfield\models\fields\LayoutField;
use lenz\contentfield\models\values\LayoutColumnValue;
use lenz\contentfield\models\values\LayoutValue;

/**
 * Class BootstrapGrid
 */
class BootstrapGrid implements GridInterface
{
  /**
   * @var array
   */
  public $baseColumnClassName = [];

  /**
   * @var string
   */
  public $rowClassName = 'row';


  /**
   * @inheritDoc
   */
  public function display(LayoutValue $layout, array $variables = []) {
    echo '<div class="', $this->rowClassName, '">';

    foreach ($layout->getColumns() as $column) {
      echo '<div class="', $this->getColumnClassName($column), '">';
      $column->display($variables);
      echo '</div>';
    }

    echo '</div>';
  }

  /**
   * @param LayoutColumnValue $column
   * @param int $value
   * @param string $attribute
   * @param string $breakpoint
   * @return string
   */
  public function getClassName(LayoutColumnValue $column, string $attribute, int $value, string $breakpoint): string {
    $suffix = $breakpoint == 'xs' ? '' : "-$breakpoint";

    switch ($attribute) {
      case 'offset':
        if ($value == 0 && $breakpoint == 'xs') return '';
        return "offset$suffix-$value";
      case 'order':
        if ($value == 0) return "";
        if ($value < 1) $value = 'first';
        if ($value > $column->getField()->columnsPerRow) $value = 'last';
        return "order$suffix-$value";
      case 'width':
        return "col$suffix-$value";
      default:
        return "";
    }
  }

  /**
   * @param LayoutColumnValue $column
   * @return string
   */
  public function getColumnClassName(LayoutColumnValue $column): string {
    $breakpoints = array_keys($column->getField()->breakpoints);
    $offset = $column->getOffset();
    $order = $column->getOrder();
    $width = $column->getWidth();

    $classNames = array_merge(
      $this->baseColumnClassName,
      $column->getExtraClasses()
    );

    foreach ($breakpoints as $breakpoint) {
      if (array_key_exists($breakpoint, $offset)) {
        $classNames[] = $this->getClassName($column, 'offset', $offset[$breakpoint], $breakpoint);
      }

      if (array_key_exists($breakpoint, $order)) {
        $classNames[] = $this->getClassName($column, 'order', $order[$breakpoint], $breakpoint);
      }

      if (array_key_exists($breakpoint, $width)) {
        $classNames[] = $this->getClassName($column, 'width', $width[$breakpoint], $breakpoint);
      }
    }

    return implode(' ', array_filter($classNames));
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
      if (!preg_match('/^(col|offset|order)(-(sm|md|lg|xl))?-(.*)$/', $className, $match)) {
        $result['class'][] = $className;
        continue;
      }

      $attribute = $match[1] == 'col' ? 'width' : $match[1];
      $breakpoint = empty($match[3]) ? 'xs' : $match[3];
      $value = $match[4];
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

  /**
   * @inheritDoc
   */
  public function render(LayoutValue $layout, array $variables = [], array $options = []): string {
    $renderer = function(LayoutColumnValue $column) use ($variables, $options) {
      return Html::tag(
        'div',
        $column->render($variables, $options),
        ['class' => $this->getColumnClassName($column)]
      );
    };

    return Html::tag(
      'div',
      implode('', array_map($renderer, $layout->getColumns())),
      ['class' => $this->rowClassName]
    );
  }
}
