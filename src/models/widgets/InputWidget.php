<?php

namespace contentfield\models\widgets;

use contentfield\models\fields\StringField;

/**
 * Class InputWidget
 *
 * Displays a generic input field.
 */
class InputWidget extends AbstractWidget
{
  /**
   * The internal name of this widget.
   */
  const NAME = 'input';


  /**
   * @inheritdoc
   */
  static function expandFieldConfig(&$config) {
    if (
      $config['type'] === self::NAME ||
      $config['type'] === 'text'
    ) {
      $config['type'] = StringField::NAME;
      $config['widget'] = self::NAME;
    }
  }
}
