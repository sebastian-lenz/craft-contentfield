<?php

namespace lenz\contentfield\fields;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Field;
use Exception;
use lenz\contentfield\events\RootSchemasEvent;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\Plugin;
use lenz\contentfield\records\ContentRecord;
use lenz\craft\utils\foreignField\ForeignField;
use Throwable;
use yii\base\Event;

/**
 * Class ContentField
 */
class ContentField extends ForeignField
{
  /**
   * @var string[]
   */
  public $rootTemplates;

  /**
   * Event that will be fired when the content field is looking for the
   * available root schemas.
   * @event
   */
  const EVENT_ROOT_SCHEMAS = 'rootSchemas';


  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function afterElementSave(ElementInterface $element, bool $isNew) {
    parent::afterElementSave($element, $isNew);

    $value = $element->getFieldValue($this->handle);
    if (
      !($value instanceof Content) ||
      !($element instanceof Element)
    ) {
      throw new Exception('Invalid content field value.');
    }

    // Store the relations of the field. Skip if the element is just propagating,
    // and we're not localizing relations
    if (
      !$element->propagating ||
      $this->hasLocalizedRelations()
    ) {
      $referencedIds = $value->getReferencedIds();
      Plugin::getInstance()
        ->relations
        ->saveRelations($this, $element, $referencedIds);
    }
  }

  /**
   * @param Content $value
   * @param ElementInterface|null $element
   * @return ContentFieldData
   * @throws Throwable
   */
  public function getInputData(Content $value, ElementInterface $element = null) {
    return new ContentFieldData($this, $value, $element);
  }

  /**
   * @param ElementInterface|null $element
   * @return AbstractSchema[]
   * @throws Exception
   */
  public function getRootSchemas(ElementInterface $element = null) {
    $schemas = $this->rootTemplates;

    if (Event::hasHandlers($this, self::EVENT_ROOT_SCHEMAS)) {
      $event = new RootSchemasEvent([
        'element' => $element,
        'field'   => $this,
        'schemas' => $this->rootTemplates,
      ]);

      Event::trigger($this, self::EVENT_ROOT_SCHEMAS, $event);
      $schemas = $event->schemas;
    }

    return Plugin::getInstance()->schemas->getSchemas($schemas);
  }

  /**
   * @inheritDoc
   * @throws Throwable
   */
  public function getSearchKeywords($value, ElementInterface $element): string {
    return $this
      ->normalizeValue($value, $element)
      ->getSearchKeywords();
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function getSettingsHtml() {
    $settings = $this->getSettings();
    $templates = Plugin::getInstance()->schemas
      ->getTemplateLoader()
      ->getAllTemplateAsList();

    return Craft::$app->getView()->renderTemplate('contentfield/_settings', [
      'name'      => 'contentfield',
      'nameNs'    => Craft::$app->view->namespaceInputId('contentfield'),
      'settings'  => $settings,
      'templates' => $templates,
    ]);
  }

  /**
   * Whether each site should get its own unique set of relations.
   * @return boolean
   */
  public function hasLocalizedRelations() {
    return $this->translationMethod !== Field::TRANSLATION_METHOD_NONE;
  }


  // Protected methods
  // -----------------

  /**
   * @inheritDoc
   */
  protected function toRecordAttributes($model, ElementInterface $element = null) {
    $contentModel = $model instanceof Content
      ? $model->getModel()
      : null;

    return [
      'model' => is_null($contentModel)
        ? null
        : $contentModel->getSerializedData()
    ];
  }


  // Static methods
  // --------------

  /**
   * @return string
   */
  static public function displayName(): string {
    return self::t('Content field');
  }

  /**
   * @return string
   */
  public static function inputTemplate(): string {
    return 'contentfield/_input';
  }

  /**
   * @inheritdoc
   */
  public static function modelClass(): string {
    return Content::class;
  }

  /**
   * @inheritDoc
   */
  public static function recordClass(): string {
    return ContentRecord::class;
  }

  /**
   * @inheritDoc
   */
  public static function recordModelAttributes(): array {
    return ['model'];
  }

  /**
   * @inheritDoc
   */
  public static function settingsTemplate() {
    return 'contentfield/_settings';
  }

  /**
   * @inheritdoc
   */
  static public function supportedTranslationMethods(): array {
    return [
      self::TRANSLATION_METHOD_NONE,
      self::TRANSLATION_METHOD_SITE,
      self::TRANSLATION_METHOD_SITE_GROUP,
      self::TRANSLATION_METHOD_LANGUAGE,
      self::TRANSLATION_METHOD_CUSTOM,
    ];
  }

  /**
   * @inheritdoc
   */
  static public function t(string $message): string {
    return Craft::t('contentfield', $message);
  }
}
