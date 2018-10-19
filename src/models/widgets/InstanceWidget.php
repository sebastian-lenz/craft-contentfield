<?php

namespace contentfield\models\widgets;

use contentfield\models\fields\ArrayField;

/**
 * Class InstanceWidget
 *
 * Displays the form of another schema.
 */
class InstanceWidget extends AbstractWidget
{
  /**
   * The internal name of this widget.
   */
  const NAME = 'instance';


  /**
   * @inheritdoc
   */
  static function expandFieldConfig(&$config) {
    // Expand the type `instances` to an array of instance fields
    if ($config['type'] === 'instances') {
      $config = array_intersect_key($config, array(
        'name'  => true,
        'label' => true,
      )) + array(
        'type'  => ArrayField::NAME,
        'member' => array(
          'type' => self::NAME,
        ) + $config,
      );
    }
  }
}
