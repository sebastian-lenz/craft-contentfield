<?php

namespace contentfield\models\widgets;

use craft\base\ElementInterface;
use craft\base\Model;

/**
 * Class AbstractWidget
 * @package contentfield\models
 *
 * Base class of all widget definitions.
 */
abstract class AbstractWidget extends Model
{
  /**
   * The internal name of this widget.
   */
  const NAME = '@invalid';


  /**
   * AbstractWidget constructor.
   * @param array $config
   */
  public function __construct(array &$config = []) {
    parent::__construct();

    foreach ($this->attributes() as $attribute) {
      if (in_array($attribute, $config)) {
        $this->$attribute = $config[$attribute];
        unset($config[$attribute]);
      }
    }
  }

  /**
   * Return the data of this field as required by the js editor.
   *
   * @param ElementInterface|null $element
   * @return array
   */
  public function getEditorData(ElementInterface $element = null) {
    return array(
      'type' => static::NAME,
    );
  }

  /**
   * Return whether this widget creates html output.
   *
   * @return boolean
   */
  public function isHtmlWidget() {
    return false;
  }

  /**
   * Allows this widget to manipulate the given field configuration.
   *
   * Will be only invoked if the field type is not set to a valid field type
   * and will be invoked on all widget types.
   *
   * @param array $config
   */
  static function expandFieldConfig(&$config) {}
}
