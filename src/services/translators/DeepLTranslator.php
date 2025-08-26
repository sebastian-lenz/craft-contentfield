<?php

namespace lenz\contentfield\services\translators;

use Craft;
use craft\helpers\App;
use DeepL\Translator;

/**
 * Class DeepLTranslator
 */
class DeepLTranslator extends AbstractTranslator
{
  /**
   * @var string
   */
  private string $_authKey;

  /**
   * @var string
   */
  private string $_endpoint = self::DEFAULT_ENDPOINT;

  /**
   * @var string[]
   */
  private array $_localeReplacements = [
    'en' => 'en-GB'
  ];

  /**
   * The url of the API endpoint.
   */
  const DEFAULT_ENDPOINT = 'https://api-free.deepl.com';


  /**
   * @return string
   */
  public function getAuthKey(): string {
    return $this->_authKey;
  }

  /**
   * @return string
   */
  public function getEndpoint(): string {
    return empty($this->_endpoint) ? self::DEFAULT_ENDPOINT : $this->_endpoint;
  }

  /**
   * @return string[]
   */
  public function getLocaleReplacements(): array {
    return $this->_localeReplacements;
  }

  /**
   * @param string $value
   * @noinspection PhpUnused
   */
  public function setAuthKey(string $value): void {
    $this->_authKey = $value;
  }

  /**
   * @param string $value
   * @noinspection PhpUnused
   */
  public function setEndpoint(string $value): void {
    $this->_endpoint = $value;
  }

  /**
   * @param string|array $value
   * @return void
   */
  public function setLocaleReplacements(string|array $value): void {
    if (!is_array($value)) {
      $replacements = [];
      foreach (explode("\n", $value) as $line) {
        $arguments = array_values(array_filter(array_map('trim', explode(':', $line, 2))));
        if (count($arguments) == 2) {
          $replacements[$arguments[0]] = $arguments[1];
        }
      }

      $value = $replacements;
    }

    $this->_localeReplacements = $value;
  }

  /**
   * @inheritDoc
   */
  public function translate(string $sourceLanguage, string $targetLanguage, string $message): ?string {
    $translator = new Translator(App::parseEnv($this->getAuthKey()));
    $result = $translator->translateText(
      texts: $message,
      sourceLang: $sourceLanguage,
      targetLang: $this->fixTargetLanguage($targetLanguage),
      options: ['tag_handling' => 'html']
    );

    return $result->text;
  }


  // Private methods
  // ---------------

  /**
   * @param string $value
   * @return string
   */
  private function fixTargetLanguage(string $value): string {
    return array_key_exists(strtolower($value), $this->_localeReplacements)
      ? $this->_localeReplacements[strtolower($value)]
      : $value;
  }


  // Static methods
  // --------------

  /**
   * @return string
   */
  static function getDisplayName(): string {
    return 'DeepL Translation';
  }

  /**
   * @return string
   */
  static function getHandle(): string {
    return 'deepl';
  }

  /**
   * @inheritDoc
   */
  static function getSettingsHtml(): string {
    return Craft::$app->getView()->renderTemplate(
      'contentfield/_config-translator-deepl',
      self::getSettings()
    );
  }
}
