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
use lenz\contentfield\fields\content\InputData;
use lenz\contentfield\fields\content\QueryExtension;
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
 * @extends ForeignField<Content, ContentRecord>
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
  public string $compression = 'never';

  /**
   * Whether the button for synchronizing content field between languages
   * should be hidden or not.
   *
   * @var string
   */
  public string $hideSyncButton = 'never';

  /**
   * The list of root schemas set for this field. Do not manipulate
   * directly, subscribe to the ContentField::EVENT_ROOT_SCHEMAS event
   * if you want to change this value in code.
   *
   * @var string[]
   */
  public array $rootSchemas = [];

  /**
   * The list of root schemas by usage uid set for this field.
   *
   * @var string[][]
   */
  public array $rootSchemasByUsage = [];

  /**
   * Whether this field should take over the page rendering or not.
   *
   * @var bool
   */
  public bool $useAsPageTemplate = false;

  /**
   * Cached output of `ContentField::getAllRootSchemas`.
   *
   * @var AbstractSchema[][]
   */
  private array $_allRootSchemas;

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
  public function afterElementSave(ElementInterface $element, bool $isNew): void {
    parent::afterElementSave($element, $isNew);
    if (is_null($this->handle)) {
      return;
    }

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
  public function afterSave(bool $isNew): void {
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
  public function beforeElementSave(ElementInterface $element, bool $isNew): bool {
    try {
      $content = $element->getFieldValue($this->handle);
      if ($content instanceof Content) {
        $content->beforeElementSave($element, $isNew);
      }
    } catch (Throwable) {
      // Ignore
    }

    return parent::beforeElementSave($element, $isNew);
  }

  /**
   * Returns a complete list of all root schemas. Intended for the
   * field settings form. This method is slow as it has to crawl all
   * templates in the system.
   *
   * @internal
   * @return AbstractSchema[][]
   * @noinspection PhpUnused (Used in templates)
   */
  public function getAllRootSchemas(): array {
    if (!isset($this->_allRootSchemas)) {
      $groups = [];
      $schemas = $this->fetchAllRootSchemas();
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

      $this->_allRootSchemas = $groups;
    }

    return $this->_allRootSchemas;
  }

  /**
   * Returns the data required by the JavaScript editor to work.
   *
   * @param Content $value
   * @param ElementInterface|null $element
   * @param bool $disabled
   * @return InputData
   * @throws Throwable
   * @internal
   * @noinspection PhpUnused (Used in templates)
   */
  public function getInputData(Content $value, ElementInterface $element = null, bool $disabled = false): InputData {
    return new InputData($this, $value, $element, $disabled);
  }

  /**
   * Returns the root schemas that are currently available for this
   * field.
   *
   * @internal
   * @param ElementInterface|null $element
   * @return AbstractSchema[]
   * @throws Throwable
   */
  public function getRootSchemas(ElementInterface $element = null): array {
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
   * @inheritDoc
   */
  public function getSettings(): array {
    $result = parent::getSettings();
    if (array_key_exists('rootSchemasByUsage', $result)) {
      $result['rootSchemasByUsage'] = (object)$result['rootSchemasByUsage'];
    }

    return $result;
  }

  /**
   * Returns a list of all detected field usages. Used by the setting form.
   *
   * @return Usage[]
   * @internal
   * @noinspection PhpUnused
   */
  public function getUsages(): array {
    return Plugin::getInstance()->fieldUsage->findUsages($this);
  }

  /**
   * Checks whether there have been any errors while reading the template
   * index. Used by the settings form.
   *
   * @internal
   * @return bool
   * @noinspection PhpUnused
   */
  public function hasSchemaErrors(): bool {
    return !empty(Plugin::getInstance()->schemas->getAllErrors());
  }

  /**
   * Whether each site should get its own unique set of relations.
   *
   * @internal
   * @return boolean
   */
  public function hasLocalizedRelations(): bool {
    return $this->translationMethod !== Field::TRANSLATION_METHOD_NONE;
  }

  /**
   * Sets the available root schemas by usage. Primary intended as a
   * setter to be used by Craft when saving the field settings form.
   *
   * The expected value should be an array keyed by the uids returned by
   * the field usage service. Each value must be an array containing
   * `@enabled` for active mappings and a series of schema names.
   *
   * ```
   * $value = [
   *   'd686dafd-4494-4600-b82a-9316851c7bd1' => ['@enabled', 'template:_roots/*'],
   *   '00990692-a3cd-4d96-99c7-5ff1d1787607' => ['@enabled', 'template:_roots/page-default', 'template:_roots/page-special'],
   *   'c9ec637f-b59f-40fc-8baa-44f742cec588' => [''],
   * ];
   * ```
   *
   * @internal
   * @param mixed $value
   * @noinspection PhpUnused (Used by Craft when applying settings)
   */
  public function setCpRootSchemasByUsage(mixed $value): void {
    if (!is_array($value)) {
      throw new InvalidArgumentException();
    }

    $usages = [];
    foreach ($value as $uid => $schemas) {
      if (!in_array(self::ENABLED_INDICATOR, $schemas)) {
        continue;
      }

      ArrayHelper::removeValue($schemas, self::ENABLED_INDICATOR);
      $schemas = array_filter($schemas, function($schema) {
        return is_string($schema);
      });

      $usages[$uid] = $schemas;
    }

    $this->rootSchemasByUsage = $usages;
  }

  /**
   * @inheritDoc
   */
  public function settingsAttributes(): array {
    return [
      'compression',
      'hideSyncButton',
      'rootSchemas',
      'rootSchemasByUsage',
      'useAsPageTemplate'
    ];
  }

  /**
   * Decides whether the content data of the given element should be
   * compressed when being stored to the database. Returns the desired
   * compression method.
   *
   * @internal
   * @param ElementInterface|null $element
   * @return string|null
   */
  public function shouldCompress(ElementInterface $element = null): ?string {
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
   * Returns a list of all available root schemas.
   *
   * @internal
   * @return AbstractSchema[]
   */
  protected function fetchAllRootSchemas(): array {
    $schemas = Plugin::getInstance()->schemas->getAllSchemas();
    $rootSchemas = array_filter($schemas, function(AbstractSchema $schema) {
      return $schema->rootSchema;
    });

    // Marking schemas as root is optional, simply return all if none are marked.
    return count($rootSchemas) ? $rootSchemas : $schemas;
  }

  /**
   * @inheritDoc
   */
  protected function toRecordAttributes(ForeignFieldModel $model, ElementInterface $element = null): array {
    /** @noinspection PhpConditionAlreadyCheckedInspection */
    $content = $model instanceof Content ? $model : null;
    $model = is_null($content) ? null : $content->getModel();

    return [
      'model' => is_null($model)
        ? null
        : ContentRecord::encodeModel($model->getSerializedValue($element), $this->shouldCompress($element))
    ];
  }


  // Static methods
  // --------------

  /**
   * @inheritDoc
   */
  static public function displayName(): string {
    return self::t('Content field');
  }

  /**
   * @inheritDoc
   */
  public static function inputTemplate(): string {
    return 'contentfield/_input';
  }

  /**
   * @inheritDoc
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
  public static function settingsTemplate(): ?string {
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
