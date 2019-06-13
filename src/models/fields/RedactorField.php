<?php

namespace lenz\contentfield\models\fields;

use Craft;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\models\values\RedactorValue;
use craft\base\ElementInterface;
use lenz\contentfield\utilities\RedactorSettings;
use Throwable;

/**
 * Class RedactorField
 *
 * Displays a redactor input field.
 */
class RedactorField extends AbstractField
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
   * @var bool
   */
  public $searchable = true;

  /**
   * @var bool
   */
  public $translatable = true;

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
      'redactor'     => $this->getRedactorSettings($element),
      'translatable' => !!$this->translatable,
    );
  }

  /**
   * @inheritdoc
   */
  public function getEditorValue($value) {
    if (!($value instanceof RedactorValue)) {
      return null;
    }

    return $value->getRawContent();
  }

  /**
   * @return RedactorSettings|null
   */
  public function getRedactorField() {
    try {
      return new RedactorSettings([
        'purifierConfig' => $this->purifierConfig,
        'redactorConfig' => $this->redactorConfig,
      ]);
    } catch (Throwable $error) { }

    return null;
  }

  /**
   * @param ElementInterface|null $element
   * @return array
   */
  public function getRedactorSettings(ElementInterface $element = null) {
    try {
      return $this->getRedactorField()->getFieldSettings($element);
    } catch (Throwable $error) { }

    return array();
  }

  /**
   * @inheritDoc
   */
  public function getSearchKeywords($value) {
    if (!$this->searchable || !($value instanceof RedactorValue)) {
      return '';
    }

    return (string)$value->getRedactorFieldData();
  }

  /**
   * @inheritdoc
   */
  public function getSerializedValue($value) {
    if (!($value instanceof RedactorValue)) {
      return null;
    }

    try {
      $field = $this->getRedactorField();
      return $field->serializeValue($value, $value->getElement());
    } catch (Throwable $error) {
      Craft::error($error->getMessage());
    }

    return $value->getRawContent();
  }

  /**
   * @return bool
   */
  public function hasRedactor() {
    return class_exists(self::REDACTOR_FIELD_CLASS);
  }
}
