<?php

namespace lenz\contentfield\fields\content;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\helpers\Cp;
use craft\helpers\Html;
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
  private bool $_disabled;

  /**
   * @var ElementInterface|null
   */
  private ?ElementInterface $_element;

  /**
   * @var ContentField
   */
  private ContentField $_field;

  /**
   * @var Content|null
   */
  private ?Content $_value;

  /**
   * @var array
   */
  private array $_rootSchemas;

  /**
   * @var array
   */
  private array $_schemaErrors;

  /**
   * @var string
   */
  private string $_schemaScripts;

  /**
   * @var array
   */
  private array $_schemas;

  /**
   * @var array
   */
  const CARD_TYPES = [
    ['card', 'card', []],
    ['largeChip', 'chip', ['size' => Cp::CHIP_SIZE_LARGE]],
    ['smallChip', 'chip', ['size' => Cp::CHIP_SIZE_SMALL]],
  ];


  /**
   * InputData constructor.
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
   * @noinspection PhpUnused
   */
  public function hasSchemaErrors(): bool {
    return count($this->_schemaErrors) > 0;
  }


  // Private methods
  // ---------------

  /**
   * @throws Throwable
   */
  private function loadSchemas(): void {
    $rootSchemas = $this->_field->getRootSchemas($this->_element);
    $allSchemas = Plugin::getInstance()
      ->schemas
      ->getDependedSchemas($rootSchemas);

    $errors = [];
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

    $this->_rootSchemas = array_keys($rootSchemas);
    $this->_schemas = $schemas;
    $this->_schemaErrors = $errors;
    $this->_schemaScripts = $scripts;
  }

  /**
   * @return array
   */
  private function getElementConfig(): array {
    $element = $this->_element;
    $result = [
      'disabled'       => $this->_disabled,
      'elementId'      => null,
      'elementSiteId'  => null,
      'fieldHandle'    => $this->_field->handle,
      'hideSyncButton' => $this->getHideSyncButton(),
      'references'     => [],
      'supportedSites' => [],
    ];

    if (is_null($element)) {
      return $result;
    }

    try {
      /** @var Element $element */
      $elementSiteId = intval($element->site->id);
    } catch (Throwable) {
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

    return array_merge($result, [
      'elementId'      => intval($element->getId()),
      'elementSiteId'  => $elementSiteId,
      'references'     => $this->loadReferences($this->_value),
      'supportedSites' => $supportedSites
    ]);
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
        'reference' => $urls->createUrl('contentfield/cp/reference'),
        'translate' => $urls->createUrl('contentfield/cp/translate'),
      ],
    ];
  }

  /**
   * @return bool
   */
  private function getHideSyncButton(): bool {
    $hideSyncButton = $this->_field->hideSyncButton;
    if ($hideSyncButton == 'always') {
      return true;
    }

    if (str_starts_with($hideSyncButton, 'site:')) {
      $element = $this->_element;
      $site = $element?->getSite();
      return $site && $hideSyncButton == "site:$site->handle";
    }

    return false;
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

    $siteId = $content->getOwnerSite()->id;
    $model = $content->getModel();
    if (!($model instanceof InstanceValue)) {
      return [];
    }

    return array_map(
      self::toReference(...),
      $model->getReferenceMap()->queryAll($siteId)
    );
  }

  /**
   * @param Element $element
   * @return array
   */
  static function toReference(Element $element): array {
    return [
      'cards' => self::renderCards($element),
      'hasThumb' => false,
      'id' => intval($element->id),
      'label' => (string)$element,
      'siteId' => $element->siteId,
      'status' => $element->getStatus(),
      'type' => get_class($element),
      'url' => $element->getUrl(),
    ];
  }

  /**
   * @param Element $element
   * @return array
   */
  static private function renderCards(Element $element): array {
    $cards = [];
    $view = Craft::$app->getView();
    $namespace = $view->getNamespace();
    $common = [
      'context' => 'field',
      'showActionMenu' => true,
    ];

    foreach (self::CARD_TYPES as list($name, $type, $config)) {
      $view->startJsBuffer();
      $html = $type == 'card'
        ? Cp::elementCardHtml($element, [
          ...$common,
          ...$config,
        ]) : Cp::elementChipHtml($element, [
          ...$common,
          ...$config,
        ]);

      $cards[$name] = [
        'html' => $namespace ? Html::namespaceHtml($html, $namespace) : $html,
        'id' => uniqid(),
        'script' => $view->clearJsBuffer(false),
      ];
    }

    return $cards;
  }
}
