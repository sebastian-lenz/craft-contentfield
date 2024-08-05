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
  private string $_endpoint = self::DEFAULT_ENDPOINT;

  /**
   * @var string
   */
  private string $_authKey;

  /**
   * The url of the API endpoint.
   */
  const DEFAULT_ENDPOINT = 'https://api-free.deepl.com';


  /**
   * @return string
   */
  public function getEndpoint(): string {
    return empty($this->_endpoint) ? self::DEFAULT_ENDPOINT : $this->_endpoint;
  }

  /**
   * @return string
   */
  public function getAuthKey(): string {
    return $this->_authKey;
  }

  /**
   * @param string $value
   * @noinspection PhpUnused
   */
  public function setEndpoint(string $value): void {
    $this->_endpoint = $value;
  }

  /**
   * @param string $value
   * @noinspection PhpUnused
   */
  public function setAuthKey(string $value): void {
    $this->_authKey = $value;
  }

  /**
   * @inheritDoc
   */
  public function translate(string $sourceLanguage, string $targetLanguage, string $message): ?string {
    $translator = new Translator(App::parseEnv($this->getAuthKey()));
    $result = $translator->translateText($message, $sourceLanguage, $targetLanguage, [
      'tag_handling' => 'html'
    ]);

    return $result->text;
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
