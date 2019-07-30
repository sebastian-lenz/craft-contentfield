<?php

namespace lenz\contentfield\fields;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\ArrayHelper;
use Exception;
use InvalidArgumentException;
use lenz\contentfield\events\RootSchemasEvent;
use lenz\contentfield\fields\content\QueryExtension;
use lenz\contentfield\fields\content\InputData;
use lenz\contentfield\helpers\CompressRecordsJob;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\Plugin;
use lenz\contentfield\records\ContentRecord;
use lenz\contentfield\services\fieldUsages\Usage;
use lenz\craft\utils\foreignField\ForeignField;
use lenz\craft\utils\foreignField\ForeignFieldModel;
use Throwable;
use yii\base\Event;

/**
 * Class ContentField
 */
class ContentField extends ForeignField
{
  /**
   * Whether we should store compressed data to the database. Should
   * one of the the following values:
   * - `always`: Always compress the data
   * - `archive`: Compress drafts and revisions
   * - `never`: Never compress content data
   *
   * @var string
   */
  public $compression = 'never';

  /**
   * @var string[]
   */
  public $rootSchemas = [];

  /**
   * @var string[][]
   */
  public $rootSchemasByUsage = [];

  /**
   * @var bool
   */
  public $useAsPageTemplate = false;

  /**
   * Value used by cp settings to mark enabled type settings.
   */
  const ENABLED_INDICATOR = '@enabled';

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
   * @inheritDoc
   */
  public function afterSave(bool $isNew) {
    $oldCompression = is_array($this->oldSettings) && array_key_exists('compression', $this->oldSettings)
      ? $this->oldSettings['compression']
      : 'never';

    if ($oldCompression != $this->compression) {
      $recordIds = ContentRecord::find()
        ->where([ 'fieldId' => $this->id ])
        ->select(['id'])
        ->column();

      foreach (array_chunk($recordIds, 250) as $chunk) {
        Craft::$app->getQueue()->push(new CompressRecordsJob([
          'fieldId'   => $this->id,
          'recordIds' => $chunk,
        ]));
      }
    }

    parent::afterSave($isNew);
  }

  /**
   * @inheritDoc
   */
  public function beforeSave(bool $isNew): bool {
    return parent::beforeSave($isNew);
  }

  /**
   * @return AbstractSchema[]
   */
  public function getAllRootSchemas() {
    $schemas = Plugin::getInstance()->schemas->getAllSchemas();
    $rootSchemas = array_filter($schemas, function(AbstractSchema $schema) {
      return $schema->rootSchema;
    });

    // Marking schemas as root is optional, simply return all if none are marked.
    return count($rootSchemas) ? $rootSchemas : $schemas;
  }

  /**
   * @return AbstractSchema[][]
   */
  public function getAllRootSchemasGrouped() {
    $groups = [];
    $schemas = $this->getAllRootSchemas();
    usort($schemas, function(AbstractSchema $a, AbstractSchema $b) {
      return strcmp($a->label, $b->label);
    });

    foreach ($schemas as $schema) {
      $offset = strrpos($schema->qualifier, '/');
      $group = $offset === false
        ? '*'
        : substr($schema->qualifier, 0, $offset);

      $groups[$group][] = $schema;
    }

    return $groups;
  }

  /**
   * @param Content $value
   * @param ElementInterface|null $element
   * @param bool $disabled
   * @return InputData
   * @throws Throwable
   */
  public function getInputData(Content $value, ElementInterface $element = null, $disabled = false) {
    return new InputData($this, $value, $element, $disabled);
  }

  /**
   * @param ElementInterface|null $element
   * @return AbstractSchema[]
   * @throws Throwable
   */
  public function getRootSchemas(ElementInterface $element = null) {
    $schemas = $this->rootSchemas;
    $uids = Plugin::getInstance()->fieldUsage->toUids($element);

    foreach ($uids as $uid) {
      if (array_key_exists($uid, $this->rootSchemasByUsage)) {
        $schemas = $this->rootSchemasByUsage[$uid];
        break;
      }
    }

    if (Event::hasHandlers($this, self::EVENT_ROOT_SCHEMAS)) {
      $event = new RootSchemasEvent([
        'element' => $element,
        'field'   => $this,
        'schemas' => $schemas,
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
   * @return Usage[]
   */
  public function getUsages() {
    return Plugin::getInstance()->fieldUsage->findUsages($this);
  }

  /**
   * Whether each site should get its own unique set of relations.
   * @return boolean
   */
  public function hasLocalizedRelations() {
    return $this->translationMethod !== Field::TRANSLATION_METHOD_NONE;
  }

  /**
   * @param array $value
   */
  public function setCpRootSchemasByUsage($value) {
    if (!is_array($value)) {
      throw new InvalidArgumentException();
    }

    $usages = [];
    foreach ($value as $uid => $schemas) {
      if (!in_array(self::ENABLED_INDICATOR, $schemas)) {
        continue;
      }

      ArrayHelper::removeValue($schemas, self::ENABLED_INDICATOR);
      $usages[$uid] = $schemas;
    }

    $this->rootSchemasByUsage = $usages;
  }

  /**
   * This settings has been renamed to `rootSchemas`. This method
   * helps bootstrapping old installs before the migration has run.
   *
   * @param array $value
   * @deprecated
   */
  public function setRootTemplates($value) {
    $this->rootSchemas = $value;
  }

  /**
   * @return array
   */
  public function settingsAttributes(): array {
    return ['compression', 'rootSchemas', 'rootSchemasByUsage', 'useAsPageTemplate'];
  }

  /**
   * @param ElementInterface|null $element
   * @return string|null
   */
  public function shouldCompress(ElementInterface $element = null) {
    $compression = ContentRecord::getAvailableCompression();

    if ($this->compression == 'always') {
      return $compression;
    } elseif ($this->compression == 'never' || is_null($element)) {
      return null;
    }

    return $element->getIsDraft() || $element->getIsRevision()
      ? $compression
      : null;
  }


  // Protected methods
  // -----------------

  /**
   * @inheritDoc
   */
  protected function toRecordAttributes(ForeignFieldModel $model, ElementInterface $element = null) {
    $content = $model instanceof Content ? $model : null;
    $contentModel = is_null($content)
      ? null
      : $content->getModel()->getSerializedValue();

    return [
      'model' => is_null($contentModel)
        ? null
        : ContentRecord::encodeModel($contentModel, $this->shouldCompress($element))
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
  public static function queryExtensionClass(): string {
    return QueryExtension::class;
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
