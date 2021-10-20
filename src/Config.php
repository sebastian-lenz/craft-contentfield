<?php

namespace lenz\contentfield;

use Craft;
use craft\base\Model;
use craft\behaviors\EnvAttributeParserBehavior;
use craft\helpers\ArrayHelper;
use lenz\contentfield\helpers\grids\BootstrapGrid;
use Throwable;

/**
 * Class Config
 */
class Config extends Model
{
  /**
   * @var string
   */
  public $cpCssFile;

  /**
   * @var string
   */
  public $googleMapsApiKey = '';

  /**
   * @var string
   */
  public $layoutGridClass = BootstrapGrid::class;

  /**
   * @var string
   */
  public $ownerVariable = '';

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
   * @inheritDoc
   */
  public function behaviors() {
    return [
      'parser' => [
        'class' => EnvAttributeParserBehavior::class,
        'attributes' => ['cpCssFile'],
      ],
    ];
  }

  /**
   * @return string
   */
  public function getGoogleMapsApiKey(): string {
    return Craft::parseEnv($this->googleMapsApiKey);
  }

  /**
   * @return array
   */
  public function getEnvironmentModes(): array {
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
  public function getTranslatorSetting(string $handle, string $name): ?string {
    try {
      return ArrayHelper::getValue($this->translatorSettings, [$handle, $name]);
    } catch (Throwable $error) {
      return null;
    }
  }

  /**
   * @param string $handle
   * @return array
   */
  public function getTranslatorSettings(string $handle): array {
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
      [['googleMapsApiKey', 'ownerVariable'], 'string'],
      [['templateInlining', 'templateIndexCache', 'templateModificationCheck'], 'in', 'skipOnEmpty' => false, 'range' => $environmentModes],
      [['translator'], 'in', 'skipOnEmpty' => true, 'range' => $translators],
      [['translatorSettings'], 'validateTranslatorSettings']
    ];
  }

  /**
   * @return bool
   */
  public function useTemplateInlining(): bool {
    return $this->resolveEnvironmentMode($this->templateInlining);
  }

  /**
   * @return bool
   */
  public function useTemplateIndexCache(): bool {
    return $this->resolveEnvironmentMode($this->templateIndexCache);
  }

  /**
   * @return bool
   */
  public function useTemplateModificationCheck(): bool {
    return $this->resolveEnvironmentMode($this->templateModificationCheck);
  }

  /**
   * @param string $attribute
   * @return bool
   */
  public function validateTranslatorSettings(string $attribute): bool {
    return is_array($this->$attribute);
  }


  // Protected methods
  // -----------------

  /**
   * @param string $mode
   * @return bool
   */
  private function resolveEnvironmentMode(string $mode): bool {
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
  static public function getInstance(): Config {
    return Plugin::getInstance()->getSettings();
  }
}
