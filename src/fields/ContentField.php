<?php

namespace contentfield\fields;

use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Json;
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

    $schemas = Plugin::getSchemaManager();

    if (is_string($value)) {
      $model = $schemas->createValue(json_decode($value, true));
    } else if (is_array($value) && isset($value['isCpFormData'])) {
      $model = $schemas->createValue(json_decode($value['content'], true));
    } elseif (is_array($value)) {
      throw new \Exception('Check me!');
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
  private function loadReferences(Content $content) {
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
   * @param Content $value
   * @param ElementInterface|null $element
   * @return string
   * @throws \Twig_Error_Loader
   * @throws \yii\base\Exception
   */
  public function getInputHtml($value, ElementInterface $element = null): string {
    $view = \Craft::$app->getView();
    $view->registerAssetBundle(CpAssetBundle::class);

    $schemaManager = Plugin::getSchemaManager();
    $rootSchemas   = $schemaManager->getSchemas($this->rootTemplates);
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
      'config' => array(
        'googleMapsApiKey' => Plugin::getInstance()->getSettings()->googleMapsApiKey,
        'elementId'        => is_null($element) ? null : $element->getId(),
        'i18nCategory'     => Plugin::$TRANSLATION_CATEGORY,
        'references'       => $this->loadReferences($value),
        'rootSchemas'      => array_map(function($schema) {
          return $schema->qualifier;
        }, $rootSchemas),
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
      'templates' => Plugin::$instance->getSchemaManager()->getTemplateLoader()->getAllTemplateAsList(),
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

    return json_encode(is_null($value->model) ? null : $value->model->getEditorData());
  }

  /**
   * @return string
   */
  static public function displayName(): string {
    return \Craft::t('contentfield', 'Content field');
  }
}
