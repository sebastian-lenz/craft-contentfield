<?php

namespace lenz\contentfield;

use craft\base\Model;
use craft\behaviors\EnvAttributeParserBehavior;
use craft\helpers\App;
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
  public string $cpCssFile;

  /**
   * @var string
   */
  public string $googleMapsApiKey = '';

  /**
   * @var string
   */
  public string $layoutGridClass = BootstrapGrid::class;

  /**
   * @var string
   */
  public string $ownerVariable = '';

  /**
   * @var string
   */
  public string $templateInlining = 'production';

  /**
   * @var string
   */
  public string $templateIndexCache = 'production';

  /**
   * @var string
   */
  public string $templateModificationCheck = 'dev';

  /**
   * @var string
   */
  public string $translator = '';

  /**
   * @var array
   */
  public array $translatorSettings = [];


  /**
   * @inheritDoc
   */
  public function behaviors(): array {
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
    return App::parseEnv($this->googleMapsApiKey);
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
   * @noinspection PhpUnused (Template method)
   */
  public function getTranslatorSetting(string $handle, string $name): ?string {
    try {
      return ArrayHelper::getValue($this->translatorSettings, [$handle, $name]);
    } catch (Throwable) {
      return null;
    }
  }

  /**
   * @param string $handle
   * @return array
   */
  public function getTranslatorSettings(string $handle): array {
    if (
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
  public function rules(): array {
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
   * @noinspection PhpUnused (Validator)
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
    return match ($mode) {
      'never' => false,
      'dev' => CRAFT_ENVIRONMENT == 'dev',
      'staging' => CRAFT_ENVIRONMENT == 'staging',
      'production' => CRAFT_ENVIRONMENT == 'production',
      'notDev' => CRAFT_ENVIRONMENT != 'dev',
      'notProduction' => CRAFT_ENVIRONMENT != 'production',
      default => true,
    };
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
