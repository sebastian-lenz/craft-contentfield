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
use ReflectionException;
use yii\base\InvalidConfigException;

/**
 * Class FieldProxy
 */
class FieldProxy extends Field
{
  /**
   * @var ReflectionClass
   */
  public $reflection;


  /**
   * RedactorSettings constructor.
   * @param array $config
   * @throws ReflectionException
   */
  public function __construct(array $config = []) {
    parent::__construct($config);
    $this->reflection = new ReflectionClass($this);
  }

  /**
   * @param Element|null $element
   * @return array|string
   * @throws SiteNotFoundException
   * @throws InvalidConfigException
   */
  public function getFieldSettings(Element $element = null) {
    // Register the asset/redactor bundles
    $view = Craft::$app->getView();
    $view->registerAssetBundle(FieldAsset::class);

    /** @var RedactorAsset $bundle */
    $bundle = $view->getAssetManager()->getBundle(RedactorAsset::class);
    $redactorLang = $bundle::$redactorLanguage ?? 'en';

    // Register plugins
    $redactorConfig = $this->getRedactorConfig();
    if (isset($redactorConfig['plugins'])) {
      foreach ($redactorConfig['plugins'] as $plugin) {
        Field::registerRedactorPlugin($plugin);
      }
    }

    $site = $element
      ? $element->getSite()
      : Craft::$app->getSites()->getCurrentSite();

    $settings = [
      'linkOptions'    => $this->getLinkOptions($element),
      'volumes'        => $this->getVolumeKeys(),
      'transforms'     => $this->getTransforms(),
      'elementSiteId'  => $site->id,
      'redactorConfig' => $redactorConfig,
      'redactorLang'   => $redactorLang,
    ];

    if (
      $this->translationMethod != self::TRANSLATION_METHOD_NONE &&
      !is_null($site->language)
    ) {
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
   */
  public function exportValue(string $value, ElementInterface $element = null) {
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
  public function parseRefs(string $value, ElementInterface $element = null) {
    try {
      $method = $this->reflection->getMethod('_parseRefs');
      $method->setAccessible(true);
      return $method->invoke($this, $value, $element);
    } catch (Exception $e) {
      return $value;
    }
  }


  // Protected methods
  // -----------------

  /**
   * @return array
   */
  protected function getRedactorConfig() {
    try {
      $method = $this->reflection->getMethod('_getRedactorConfig');
      $method->setAccessible(true);
      return $method->invoke($this);
    } catch (Exception $e) {
      return [];
    }
  }

  /**
   * @param Element|null $element
   * @return array
   */
  protected function getLinkOptions(Element $element = null) {
    try {
      $method = $this->reflection->getMethod('_getLinkOptions');
      $method->setAccessible(true);
      return $method->invoke($this, $element);
    } catch (Exception $e) {
      return [];
    }
  }

  /**
   * @return array
   */
  protected function getVolumeKeys() {
    try {
      $method = $this->reflection->getMethod('_getVolumeKeys');
      $method->setAccessible(true);
      return $method->invoke($this);
    } catch (Exception $e) {
      return [];
    }
  }

  /**
   * @return array
   */
  protected function getTransforms() {
    try {
      $method = $this->reflection->getMethod('_getTransforms');
      $method->setAccessible(true);
      return $method->invoke($this);
    } catch (Exception $e) {
      return [];
    }
  }
}
