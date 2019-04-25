<?php

namespace lenz\contentfield\models\fields\strings;

use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\models\values\RedactorValue;
use craft\base\ElementInterface;

/**
 * Class RedactorField
 *
 * Displays a redactor input field.
 */
class RedactorField extends AbstractStringField
{
  /**
   * @var string|null
   */
  public $purifierConfig = null;

  /**
   * @var string|null
   */
  public $redactorConfig = 'Standard.json';

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
  public function createValue($data, ValueInterface $parent) {
    return new RedactorValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + array(
      'redactor' => $this->getRedactorSettings($element)
    );
  }

  /**
   * @return \lenz\contentfield\utilities\RedactorSettings|null
   */
  public function getRedactorField() {
    try {
      return new \lenz\contentfield\utilities\RedactorSettings([
        'purifierConfig' => $this->purifierConfig,
        'redactorConfig' => $this->redactorConfig,
      ]);
    } catch (\Throwable $error) { }

    return null;
  }

  /**
   * @param ElementInterface|null $element
   * @return array
   */
  public function getRedactorSettings(ElementInterface $element = null) {
    try {
      return $this->getRedactorField()->getFieldSettings($element);
    } catch (\Throwable $error) { }

    return array();
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
  public function isHtmlField() {
    return true;
  }
}
