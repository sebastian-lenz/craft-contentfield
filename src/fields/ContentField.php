<?php

namespace lenz\contentfield\fields;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\elements\db\ElementQuery;
use craft\elements\db\ElementQueryInterface;
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
   * @var int
   */
  private static $_queryTableIndex = 0;

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

    // If we have a model, check whether the type is allowed
    $rootSchemas = $this->getRootSchemas($element);
    $rootSchemasTypes = array_map(
      function($schema) { return $schema->qualifier; },
      $rootSchemas
    );

    if (!is_null($model) && !in_array($model->getType(), $rootSchemasTypes)) {
      $model = null;
    }

    // If we don't have a model and there is only one schema
    // available, create a model from it
    if (is_null($model) && count($rootSchemas) === 1) {
      $model = new InstanceValue([], $rootSchemas[0], null, null);
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
   * @inheritDoc
   */
  public function modifyElementsQuery(ElementQueryInterface $query, $value) {
    if (!($query instanceof ElementQuery)) {
      return;
    }

    if ($this->enableEagerLoad($query)) {
      $tableName = 'contentfield_' . (self::$_queryTableIndex++);
      $query->query->leftJoin(
        ContentRecord::TABLE . ' ' . $tableName,
        implode(' AND ', [
          "[[{$tableName}.elementId]] = [[elements.id]]",
          "[[{$tableName}.siteId]] = [[elements_sites.siteId]]",
          "[[{$tableName}.fieldId]] = {$this->id}"
        ])
      );

      $query->addSelect([
        "field:{$this->handle}" => "{$tableName}.content"
      ]);
    }
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
   * @param ElementQuery $query
   * @return bool
   */
  private function enableEagerLoad(ElementQuery $query) {
    // Ignore count queries
    if (
      count($query->select) == 1 &&
      $query->select[0] == 'COUNT(*)'
    ) {
      return false;
    }

    $handle = $this->handle;
    if ($query->with == $handle) {
      $query->with = null;
      return true;
    }

    if (is_array($query->with) && in_array($handle, $query->with)) {
      $query->with = array_filter(
        $query->with,
        function($with) use ($handle) {
          return $with != $handle;
        }
      );

      return true;
    }

    return false;
  }

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
      'content'  => $data->getContent(),
      'name'     => $this->handle,
      'nameNs'   => Craft::$app->view->namespaceInputId($this->handle),
      'payload'  => $data->getPayload(),
      'scripts'  => $data->getScripts(),
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
