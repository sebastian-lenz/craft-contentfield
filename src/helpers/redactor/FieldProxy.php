<?php

namespace lenz\contentfield\helpers\redactor;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\errors\SiteNotFoundException;
use craft\redactor\assets\field\FieldAsset;
use craft\redactor\assets\redactor\RedactorAsset;
use craft\redactor\Field;
use Exception;
use ReflectionClass;
use yii\base\InvalidConfigException;

/**
 * Class FieldProxy
 */
class FieldProxy extends Field
{
  /**
   * @var ReflectionClass
   */
  public ReflectionClass $reflection;


  /**
   * RedactorSettings constructor.
   * @param array $config
   */
  public function __construct(array $config = []) {
    parent::__construct($config);
    $this->reflection = new ReflectionClass($this);
  }

  /**
   * @param Element|null $element
   * @return array
   * @throws SiteNotFoundException
   * @throws InvalidConfigException
   */
  public function getFieldSettings(Element $element = null): array {
    // register the asset/redactor bundles
    $view = Craft::$app->getView();
    $view->registerAssetBundle(FieldAsset::class);

    // figure out which language we ended up with
    /** @var RedactorAsset $bundle */
    $bundle = $view->getAssetManager()->getBundle(RedactorAsset::class);
    $redactorLang = $bundle::$redactorLanguage ?? 'en';

    // register plugins
    $redactorConfig = $this->getRedactorConfig();

    if (isset($redactorConfig['plugins'])) {
      foreach ($redactorConfig['plugins'] as $plugin) {
        static::registerRedactorPlugin($plugin);
      }
    }

    if (!$this->showHtmlButtonForNonAdmins && !Craft::$app->getUser()->getIsAdmin()) {
      $redactorConfig['buttonsHide'] = array_merge($redactorConfig['buttonsHide'] ?? [], ['html']);
    }

    $sitesService = Craft::$app->getSites();
    $site = ($element ? $element->getSite() : $sitesService->getCurrentSite());

    $defaultTransform = '';
    if (
      !empty($this->defaultTransform) &&
      $transform = Craft::$app->getImageTransforms()->getTransformByUid($this->defaultTransform)
    ) {
      $defaultTransform = $transform->handle;
    }

    $allSites = [];
    foreach ($sitesService->getAllSites(false) as $allSite) {
      $allSites[$allSite->id] = $allSite->name;
    }

    $settings = [
      // 'id' => $view->namespaceInputId($id),   <-- Will be set by React
      'linkOptions' => $this->getLinkOptions($element),
      'volumes' => $this->getVolumeKeys(),
      'transforms' => $this->getTransforms(),
      'defaultTransform' => $defaultTransform,
      'elementSiteId' => $site->id,
      'allSites' => $allSites,
      'redactorConfig' => $redactorConfig,
      'redactorLang' => $redactorLang,
      'showAllUploaders' => $this->showUnpermittedFiles,
    ];

    if ($this->translationMethod != self::TRANSLATION_METHOD_NONE) {
      // Explicitly set the text direction
      $locale = Craft::$app->getI18n()->getLocaleById($site->language);
      $settings['direction'] = $locale->getOrientation();
    }

    RedactorAsset::registerTranslations($view);
    return $settings;
  }

  /**
   * @param string $value
   * @param ElementInterface|null $element
   * @return string
   * @noinspection PhpUnused
   */
  public function exportValue(string $value, ElementInterface $element = null): string {
    return str_replace(
      '<!--pagebreak-->',
      '<hr class="redactor_pagebreak" style="display:none" unselectable="on" contenteditable="false" />',
      $this->parseRefs($value, $element)
    );
  }

  /**
   * @param string $value
   * @param ElementInterface|null $element
   * @return string
   */
  public function parseRefs(string $value, ElementInterface $element = null): string {
    try {
      $method = $this->reflection->getMethod('_parseRefs');
      $method->setAccessible(true);
      return $method->invoke($this, $value, $element);
    } catch (Exception) {
      return $value;
    }
  }


  // Protected methods
  // -----------------

  /**
   * @return array
   */
  protected function getRedactorConfig(): array {
    try {
      $method = $this->reflection->getMethod('_getRedactorConfig');
      $method->setAccessible(true);
      return $method->invoke($this);
    } catch (Exception) {
      return [];
    }
  }

  /**
   * @param Element|null $element
   * @return array
   */
  protected function getLinkOptions(Element $element = null): array {
    try {
      $method = $this->reflection->getMethod('_getLinkOptions');
      $method->setAccessible(true);
      return $method->invoke($this, $element);
    } catch (Exception) {
      return [];
    }
  }

  /**
   * @return array
   */
  protected function getVolumeKeys(): array {
    try {
      $method = $this->reflection->getMethod('_getVolumeKeys');
      $method->setAccessible(true);
      return $method->invoke($this);
    } catch (Exception) {
      return [];
    }
  }

  /**
   * @return array
   */
  protected function getTransforms(): array {
    try {
      $method = $this->reflection->getMethod('_getTransforms');
      $method->setAccessible(true);
      return $method->invoke($this);
    } catch (Exception) {
      return [];
    }
  }
}
