<?php

namespace lenz\contentfield\fields\content;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\helpers\Json;
use lenz\contentfield\fields\ContentField;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\Plugin;
use Throwable;

/**
 * Class InputData
 */
class InputData
{
  /**
   * @var bool
   */
  private $_disabled;

  /**
   * @var ElementInterface|null
   */
  private $_element;

  /**
   * @var ContentField
   */
  private $_field;

  /**
   * @var Content|null
   */
  private $_value;

  /**
   * @var array
   */
  private $_rootSchemas;

  /**
   * @var array
   */
  private $_schemaErrors;

  /**
   * @var string
   */
  private $_schemaScripts;

  /**
   * @var array
   */
  private $_schemas;


  /**
   * ContentFieldData constructor.
   *
   * @param ContentField $field
   * @param Content|null $value
   * @param ElementInterface|null $element
   * @param bool $disabled
   * @throws Throwable
   */
  public function __construct(
    ContentField $field,
    Content $value = null,
    ElementInterface $element = null,
    bool $disabled = false
  ) {
    $this->_disabled = $disabled;
    $this->_element = $element;
    $this->_field = $field;
    $this->_value = $value;

    $this->loadSchemas();
  }

  /**
   * @return string
   */
  public function getContent(): string {
    return Json::encode(is_null($this->_value)
      ? null
      : $this->_value->getEditorValue()
    );
  }

  /**
   * @return string
   * @noinspection PhpUnused (Used in templates)
   */
  public function getPayload(): string {
    return Json::encode([
      'config' => array_merge(
        $this->getGlobalConfig(),
        $this->getElementConfig()
      ),
      'schemas' => $this->_schemas,
    ]);
  }

  /**
   * @return array
   * @noinspection PhpUnused (Used in templates)
   */
  public function getSchemaErrors(): array {
    return $this->_schemaErrors;
  }

  /**
   * @return string
   * @noinspection PhpUnused (Used in templates)
   */
  public function getScripts(): string {
    return $this->_schemaScripts;
  }

  /**
   * @return bool
   */
  public function hasSchemaErrors(): bool {
    return count($this->_schemaErrors) > 0;
  }


  // Private methods
  // ---------------

  /**
   * @throws Throwable
   */
  private function loadSchemas() {
    $rootSchemas = $this->_field->getRootSchemas($this->_element);
    $allSchemas = Plugin::getInstance()
      ->schemas
      ->getDependedSchemas($rootSchemas);

    $errors  = [];
    $schemas = [];
    $scripts = '';

    foreach ($allSchemas as $name => $schema) {
      if (!$schema->validate()) {
        $errors[] = $schema;
      } else {
        $scripts .= $schema->getClientValidationScript();
        $schemas[$name] = $schema->getEditorData($this->_element);
      }
    }

    $this->_rootSchemas   = array_keys($rootSchemas);
    $this->_schemas       = $schemas;
    $this->_schemaErrors  = $errors;
    $this->_schemaScripts = $scripts;
  }

  /**
   * @return array
   */
  private function getElementConfig(): array {
    $element = $this->_element;

    if (is_null($element)) {
      return [
        'disabled'       => $this->_disabled,
        'elementId'      => null,
        'elementSiteId'  => null,
        'fieldHandle'    => $this->_field->handle,
        'references'     => [],
        'supportedSites' => [],
      ];
    }

    try {
      /** @var Element $element */
      $elementSiteId = intval($element->site->id);
    } catch (Throwable $error) {
      $elementSiteId = null;
    }

    $supportedSites = [];
    foreach ($element->getSupportedSites() as $siteInfo) {
      $siteId = is_array($siteInfo) ? $siteInfo['siteId'] : $siteInfo;
      $site = Craft::$app->getSites()->getSiteById($siteId);
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
      'disabled'       => $this->_disabled,
      'elementId'      => intval($element->getId()),
      'elementSiteId'  => $elementSiteId,
      'fieldHandle'    => $this->_field->handle,
      'references'     => $this->loadReferences($this->_value),
      'supportedSites' => $supportedSites
    ];
  }

  /**
   * @return array
   */
  private function getGlobalConfig(): array {
    $plugin = Plugin::getInstance();
    $urls   = Craft::$app->urlManager;

    return [
      'csrfTokenName'  => Craft::$app->request->csrfParam,
      'csrfTokenValue' => Craft::$app->request->csrfToken,
      'googleMapsApiKey' => $plugin->getSettings()->getGoogleMapsApiKey(),
      'hasTranslator'    => $plugin->translators->hasTranslator(),
      'rootSchemas'      => $this->_rootSchemas,
      'apiEndpoints'     => [
        'anchors'   => $urls->createUrl('contentfield/cp/anchors'),
        'fetchSite' => $urls->createUrl('contentfield/cp/fetch'),
        'oembed'    => $urls->createUrl('contentfield/cp/oembed'),
        'translate' => $urls->createUrl('contentfield/cp/translate'),
      ],
    ];
  }


  // Static methods
  // --------------

  /**
   * @param Content|null $content
   * @return array
   */
  static public function loadReferences(Content $content = null): array {
    if (is_null($content)) {
      return [];
    }

    $model = $content->getModel();
    if (!($model instanceof InstanceValue)) {
      return [];
    }

    $siteId = $content->getOwnerSite()->id;
    $view = Craft::$app->getView();
    return array_map(function(Element $element) use ($view) {
      $context = [
        'element' => $element,
        'context' => 'field',
        'size'    => 'large'
      ];

      return [
        'element'  => $view->invokeHook('cp.elements.element', $context),
        'hasThumb' => false,
        'id'       => intval($element->id),
        'label'    => (string)$element,
        'siteId'   => $element->siteId,
        'status'   => $element->getStatus(),
        'type'     => get_class($element),
        'url'      => $element->getUrl(),
      ];
    }, $model->getReferenceMap()->queryAll($siteId));
  }
}
