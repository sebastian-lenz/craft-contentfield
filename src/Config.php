<?php

namespace lenz\contentfield;

use Craft;
use craft\base\Model;
use craft\helpers\ArrayHelper;
use craft\helpers\FileHelper;
use Throwable;

/**
 * Class Config
 */
class Config extends Model
{
  /**
   * @var string
   */
  public $googleMapsApiKey = '';

  /**
   * @var string
   */
  public $templateInlining = 'production';

  /**
   * @var string
   */
  public $templateIndexCache = 'production';

  /**
   * @var string
   */
  public $templateModificationCheck = 'dev';

  /**
   * @var string
   */
  public $translator = '';

  /**
   * @var array
   */
  public $translatorSettings = [];

  /**
   * A list of attributes for which we must clear the cache when changed.
   */
  const CLEAR_CACHE_ATTRIBUTES = [
    'templateInlining',
    'templateIndexCache',
    'templateModificationCheck'
  ];


  /**
   * @return bool
   */
  public function useTemplateInlining() {
    return $this->resolveEnvironmentMode($this->templateInlining);
  }

  /**
   * @return bool
   */
  public function enableTemplateIndexCache() {
    return $this->resolveEnvironmentMode($this->templateIndexCache);
  }

  /**
   * @return bool
   */
  public function enableTemplateModificationCheck() {
    return $this->resolveEnvironmentMode($this->templateModificationCheck);
  }

  /**
   * @return array
   */
  public function getEnvironmentModes() {
    return [
      'never'         => 'Never',
      'always'        => 'Always',
      'dev'           => 'When in development mode',
      'staging'       => 'When in staging mode',
      'production'    => 'When in production mode',
      'notDev'        => 'When not in development mode',
      'notProduction' => 'When not in production mode',
    ];
  }

  /**
   * @param string $handle
   * @param string $name
   * @return string|null
   */
  public function getTranslatorSetting(string $handle, string $name) {
    return ArrayHelper::getValue($this->translatorSettings, [$handle, $name]);
  }

  /**
   * @param string $handle
   * @return array
   */
  public function getTranslatorSettings($handle) {
    if (
      is_array($this->translatorSettings) &&
      array_key_exists($handle, $this->translatorSettings) &&
      is_array($this->translatorSettings[$handle])
    ) {
      return $this->translatorSettings[$handle];
    }

    return [];
  }

  /**
   * @return array
   */
  public function rules() {
    $environmentModes = array_keys($this->getEnvironmentModes());
    $translators = array_keys(Plugin::getInstance()->translators->getTranslatorTypeOptions());

    return [
      [['googleMapsApiKey'], 'string'],
      [['templateInlining', 'templateIndexCache', 'templateModificationCheck'], 'in', 'skipOnEmpty' => false, 'range' => $environmentModes],
      [['translator'], 'in', 'skipOnEmpty' => true, 'range' => $translators],
      [['translatorSettings'], 'validateTranslatorSettings']
    ];
  }

  /**
   * @param array $values
   * @param bool $safeOnly
   * @throws Throwable
   */
  public function setAttributes($values, $safeOnly = true) {
    $oldValues = $this->getAttributes(self::CLEAR_CACHE_ATTRIBUTES);
    parent::setAttributes($values, $safeOnly);

    foreach ($oldValues as $name => $oldValue) {
      if ($this->$name != $oldValue) {
        Craft::$app->cache->flush();

        if ($name == 'templateInlining') {
          FileHelper::clearDirectory(Craft::$app->getPath()->getCompiledTemplatesPath(false));
        }

        break;
      }
    }
  }

  /**
   * @param string $attribute
   * @return bool
   */
  public function validateTranslatorSettings($attribute) {
    return is_array($this->$attribute);
  }


  // Protected methods
  // -----------------

  /**
   * @param string $mode
   * @return bool
   */
  private function resolveEnvironmentMode($mode) {
    switch ($mode) {
      case 'never':
        return false;
      case 'dev':
        return CRAFT_ENVIRONMENT == 'dev';
      case 'staging':
        return CRAFT_ENVIRONMENT == 'staging';
      case 'production':
        return CRAFT_ENVIRONMENT == 'production';
      case 'notDev':
        return CRAFT_ENVIRONMENT != 'dev';
      case 'notProduction':
        return CRAFT_ENVIRONMENT != 'production';
      default:
        return true;
    }
  }


  // Static methods
  // --------------

  /**
   * @return Config
   */
  static public function getInstance() {
    return Plugin::getInstance()->getSettings();
  }
}
