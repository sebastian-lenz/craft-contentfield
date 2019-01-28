<?php

namespace contentfield\fields;

use contentfield\events\RootSchemasEvent;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\elements\db\ElementQuery;
use craft\helpers\Json;
use yii\base\Event;
use yii\db\Schema;

use contentfield\models\Content;
use contentfield\models\values\InstanceValue;
use contentfield\Plugin;
use contentfield\utilities\CpAssetBundle;

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

  const EVENT_ROOT_SCHEMAS = 'rootSchemas';


  /**
   * @inheritdoc
   * @throws \Throwable
   */
  public function afterElementSave(ElementInterface $element, bool $isNew) {
    // Skip if the element is just propagating, and we're not localizing relations
    /** @var Element $element */
    if (!$element->propagating || $this->localizeRelations()) {
      /** @var Content $value */
      $value = $element->getFieldValue($this->handle);
      $referencedIds = $value->getReferencedIds();

      Plugin::getInstance()
        ->relations
        ->saveRelations($this, $element, $referencedIds);
    }

    parent::afterElementSave($element, $isNew);
  }

  /**
   * @param bool $isNew
   * @return bool
   */
  public function beforeSave(bool $isNew): bool {
    return parent::beforeSave($isNew);
  }

  /**
   * Get Content Column Type
   * Used to set the correct column type in the DB
   * @return string
   */
  public function getContentColumnType(): string {
    return Schema::TYPE_TEXT;
  }

  /**
   * @param Content|string|array $value
   * @param ElementInterface|null $element
   * @return Content
   * @throws \Exception
   */
  public function normalizeValue($value, ElementInterface $element = null) {
    $model = null;
    if ($value instanceof Content) {
      return $value;
    }

    $schemas = Plugin::getInstance()->schemas;

    if (is_string($value)) {
      $model = $schemas->createValue(Json::decode($value, true));
    } else if (is_array($value) && isset($value['isCpFormData'])) {
      $model = $schemas->createValue(Json::decode($value['content'], true));
    } elseif (is_array($value)) {
      throw new \Exception('Check me!');
    }

    if (is_null($model)) {
      $schemas = $this->getRootSchemas($element);
      if (count($schemas) === 1) {
        $model = new InstanceValue([], $schemas[0], null, null);
      }
    }

    $content = new Content(array(
      'model' => $model,
      'owner' => $element,
    ));

    if (!is_null($model)) {
      $model->setContent($content);
    }

    return $content;
  }

  /**
   * @return array
  public function getElementValidationRules(): array {
    return [
      [LinkFieldValidator::class, 'field' => $this],
    ];
  }
   */

  /**
   * @param Content $content
   * @return array
   */
  static function loadReferences(Content $content) {
    if (!($content->model instanceof InstanceValue)) {
      return array();
    }

    $view = \Craft::$app->getView();
    $eagerLoadingMap = $content->model->getEagerLoadingMap();
    $result = array();

    foreach ($eagerLoadingMap as $elementType => $elementData) {
      $elements = $content->getEagerLoadedElements($elementType);

      /** @var Element $element */
      foreach ($elements as $id => $element) {
        $context = array(
          'element' => $element,
          'context' => 'field',
          'size'    => 'large'
        );

        $result[] = array(
          'element'  => $view->invokeHook('cp.elements.element', $context),
          'hasThumb' => false,
          'id'       => $id,
          'label'    => (string)$element,
          'siteId'   => $element->siteId,
          'status'   => $element->getStatus(),
          'type'     => $elementType,
          'url'      => $element->getUrl(),
        );
      }
    }

    return $result;
  }

  /**
   * Whether each site should get its own unique set of relations.
   * @return boolean
   */
  public function localizeRelations() {
    return $this->translationMethod !== Field::TRANSLATION_METHOD_NONE;
  }

  /**
   * @param ElementInterface|null $element
   * @return array
   */
  private function getElementConfig(ElementInterface $element = null) {
    if (is_null($element)) {
      return [
        'elementId'      => null,
        'elementSiteId'  => null,
        'fieldHandle'    => $this->handle,
        'supportedSites' => [],
      ];
    }

    try {
      /** @var Element $element */
      $elementSiteId = intval($element->site->id);
    } catch (\Throwable $error) {
      $elementSiteId = null;
    }

    $supportedSites = [];
    foreach ($element->getSupportedSites() as $siteInfo) {
      $siteId = is_array($siteInfo) ? $siteInfo['siteId'] : $siteInfo;
      $site = \Craft::$app->getSites()->getSiteById($siteId);
      if (is_null($site)) {
        continue;
      }

      $supportedSites[] = [
        'id'       => intval($site->id),
        'label'    => $site->name,
        'language' => $site->language,
      ];
    }

    return [
      'elementId'      => intval($element->getId()),
      'elementSiteId'  => $elementSiteId,
      'fieldHandle'    => $this->handle,
      'supportedSites' => $supportedSites
    ];
  }

  /**
   * @return array
   */
  private function getGeneralConfig() {
    $urls = \Craft::$app->urlManager;

    return [
      'apiEndpoints'     => array(
        'fetchSite'      => $urls->createUrl('contentfield/cp/fetch'),
        'oembed'         => $urls->createUrl('contentfield/cp/oembed'),
        'translate'      => $urls->createUrl('contentfield/cp/translate'),
      ),
      'googleMapsApiKey' => Plugin::getInstance()->getSettings()->googleMapsApiKey,
      'i18nCategory'     => Plugin::$TRANSLATION_CATEGORY,
    ];
  }

  /**
   * @param Content $value
   * @param ElementInterface|null $element
   * @return string
   * @throws \Exception
   */
  public function getInputHtml($value, ElementInterface $element = null): string {
    $view = \Craft::$app->getView();
    $view->registerAssetBundle(CpAssetBundle::class);

    $schemaManager = Plugin::getInstance()->schemas;
    $rootSchemas   = $this->getRootSchemas($element);
    $allSchemas    = $schemaManager->getDependedSchemas($rootSchemas);
    $schemaErrors  = array();
    $jsonSchemas   = array();

    foreach ($allSchemas as $name => $schema) {
      if (!$schema->validate()) {
        $schemaErrors[] = $schema;
      } else {
        $jsonSchemas[$name] = $schema->getEditorData($element);
      }
    }

    if (count($schemaErrors) > 0) {
      return $view->renderTemplate('contentfield/_input-error', [
        'schemas' => $schemaErrors,
      ]);
    }

    $data = array(
      'config' => array_merge(
        $this->getGeneralConfig(),
        $this->getElementConfig($element),
        array(
          'references'       => $this->loadReferences($value),
          'rootSchemas'      => array_map(function($schema) {
            return $schema->qualifier;
          }, $rootSchemas),
        )
      ),
      'schemas' => $jsonSchemas,
    );

    return $view->renderTemplate('contentfield/_input', [
      'payload'  => Json::encode($data),
      'content'  => Json::encode(is_null($value->model) ? null : $value->model->getEditorData()),
      'name'     => $this->handle,
      'nameNs'   => \Craft::$app->view->namespaceInputId($this->handle),
      'settings' => $this->getSettings(),
      'value'    => $value,
    ]);
  }

  /**
   * @param ElementInterface|null $element
   * @return \contentfield\models\schemas\AbstractSchema[]
   * @throws \Exception
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
   * @return string
   * @throws \Twig_Error_Loader
   * @throws \yii\base\Exception
   */
  public function getSettingsHtml() {
    $settings = $this->getSettings();

    return \Craft::$app->getView()->renderTemplate('contentfield/_settings', [
      'name'      => 'contentfield',
      'nameNs'    => \Craft::$app->view->namespaceInputId('contentfield'),
      'settings'  => $settings,
      'templates' => Plugin::getInstance()->getInstance()->schemas->getTemplateLoader()->getAllTemplateAsList(),
    ]);
  }

  /**
   * @param $value
   * @param ElementInterface $element
   * @return bool
   */
  public function isValueEmpty($value, ElementInterface $element): bool {
    if ($value instanceof Content) {
      return false; // $value->isEmpty();
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

    return Json::encode(is_null($value->model)
      ? null
      : $value->model->getSerializedData()
    );
  }

  /**
   * @return string
   */
  static public function displayName(): string {
    return \Craft::t('contentfield', 'Content field');
  }
}
