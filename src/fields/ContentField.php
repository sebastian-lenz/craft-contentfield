<?php

namespace lenz\contentfield\fields;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Json;
use Exception;
use lenz\contentfield\events\RootSchemasEvent;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\Plugin;
use lenz\contentfield\records\ContentRecord;
use lenz\contentfield\validators\ContentFieldValidator;
use Throwable;
use yii\base\Event;

/**
 * Class ContentField
 * @package contentfield\fields
 */
class ContentField extends Field
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

    // Update the content record
    $model = $value->getModel();
    $conditions = $this->getContentRecordConditions($element);
    if (is_null($model)) {
      ContentRecord::deleteAll($conditions);
    } else {
      $record = $this->getContentRecord($element);
      if (is_null($record)) {
        $record = new ContentRecord($conditions);
      }

      $record->content = $this->serializeValue($value, $element);
      $record->save();
    }

    parent::afterElementSave($element, $isNew);
  }

  /**
   * @param Content|string|array $value
   * @param ElementInterface|null $element
   * @return Content
   * @throws Throwable
   */
  public function normalizeValue($value, ElementInterface $element = null) {
    if ($value instanceof Content) {
      return $value;
    }

    $model = null;
    $schemas = Plugin::getInstance()->schemas;

    if (is_null($value) && $element instanceof Element) {
      $record = $this->getContentRecord($element);
      if (!is_null($record)) {
        $value = $record->content;
      }
    }

    if (is_string($value)) {
      $model = $schemas->createValue(Json::decode($value, true));
    } else if (is_array($value) && isset($value['isCpFormData'])) {
      $model = $schemas->createValue(Json::decode($value['content'], true));
    } elseif (is_array($value)) {
      throw new Exception('Check me!');
    }

    if (is_null($model)) {
      $schemas = $this->getRootSchemas($element);
      if (count($schemas) === 1) {
        $model = new InstanceValue([], $schemas[0], null, null);
      }
    }

    return new Content($model, $element);
  }

  /**
   * @inheritDoc
   */
  public function getElementValidationRules(): array {
    return [
      [ContentFieldValidator::class],
    ];
  }

  /**
   * @inheritDoc
   * @throws Throwable
   */
  public function getInputHtml($value, ElementInterface $element = null): string {
    return $this->getHtml($value, $element);
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
   * @inheritDoc
   * @throws Throwable
   */
  public function getStaticHtml($value, ElementInterface $element): string {
    return $this->getHtml($value, $element, true);
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

  /**
   * @inheritdoc
   */
  public function isValueEmpty($value, ElementInterface $element): bool {
    if ($value instanceof Content) {
      return false;
    }

    return true;
  }

  /**
   * @inheritdoc
   */
  public function serializeValue($value, ElementInterface $element = null) {
    if (!($value instanceof Content)) {
      return null;
    }

    $model = $value->getModel();
    return Json::encode(is_null($model)
      ? null
      : $model->getSerializedData()
    );
  }


  // Private methods
  // ---------------

  /**
   * @param Element $element
   * @return ContentRecord|null
   */
  private function getContentRecord(Element $element) {
    return ContentRecord::findOne(
      $this->getContentRecordConditions($element)
    );
  }

  /**
   * @param Element $element
   * @return array
   */
  private function getContentRecordConditions(Element $element) {
    return [
      'elementId' => $element->id,
      'siteId'    => $element->site->id,
      'fieldId'   => $this->id,
    ];
  }

  /**
   * @param Content $value
   * @param ElementInterface|null $element
   * @param bool $disabled
   * @return string
   * @throws Throwable
   */
  private function getHtml($value, ElementInterface $element = null, $disabled = false) {
    $view = Craft::$app->getView();
    $data = new ContentFieldData($this, $value, $element);

    if ($data->hasSchemaErrors()) {
      return $view->renderTemplate('contentfield/_input-error', [
        'schemas' => $data->getSchemaErrors(),
      ]);
    }

    return $view->renderTemplate('contentfield/_input', [
      'payload'  => $data->getPayload(),
      'content'  => $data->getContent(),
      'name'     => $this->handle,
      'nameNs'   => Craft::$app->view->namespaceInputId($this->handle),
    ]);
  }


  // Static methods
  // --------------

  /**
   * @return string
   */
  static public function displayName(): string {
    return Craft::t('contentfield', 'Content field');
  }

  /**
   * @inheritdoc
   */
  public static function hasContentColumn(): bool {
    return false;
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
}
