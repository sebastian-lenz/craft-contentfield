<?php

namespace contentfield\models\widgets;

use contentfield\models\fields\StringField;
use craft\base\ElementInterface;

/**
 * Class RedactorWidget
 * @package contentfield\models
 *
 * Displays a redactor input field.
 */
class RedactorWidget extends AbstractWidget
{
  /**
   * The internal name of this widget.
   */
  const NAME = 'redactor';

  /**
   * The class name of the redactor field.
   */
  const REDACTOR_FIELD_CLASS = '\\craft\\redactor\\Field';


  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + array(
      'redactor' => $this->getRedactorSettings()
    );
  }

  /**
   * @param ElementInterface|null $element
   * @return array
   */
  public function getRedactorSettings(ElementInterface $element = null) {
    try {
      $settings = new \contentfield\utilities\RedactorSettings();
      return $settings->getFieldSettings($element);
    } catch (\Exception $e) {
      return array();
    }
  }

  /**
   * @return bool
   */
  public function hasRedactor() {
    return class_exists(self::REDACTOR_FIELD_CLASS);
  }

  /**
   * @inheritdoc
   */
  public function isHtmlWidget() {
    return true;
  }

  /**
   * @inheritdoc
   */
  static function expandFieldConfig(&$config) {
    if ($config['type'] === self::NAME) {
      $config['type'] = StringField::NAME;
      $config['widget'] = self::NAME;
    }
  }
}
