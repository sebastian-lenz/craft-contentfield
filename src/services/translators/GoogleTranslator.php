<?php

namespace lenz\contentfield\services\translators;

use Craft;
use craft\helpers\ArrayHelper;
use craft\helpers\Json;
use lenz\craft\utils\models\Url;

/**
 * Class GoogleTranslator
 */
class GoogleTranslator extends AbstractTranslator
{
  /**
   * @var string
   */
  private string $_apiKey;

  /**
   * The url of the API endpoint.
   */
  const ENDPOINT = 'https://translation.googleapis.com/language/translate/v2';


  /**
   * @return string
   * @noinspection PhpUnused
   */
  public function getApiKey(): string {
    return $this->_apiKey;
  }

  /**
   * @param string $value
   * @noinspection PhpUnused
   */
  public function setApiKey(string $value): void {
    $this->_apiKey = $value;
  }

  /**
   * @inheritDoc
   */
  public function translate(string $sourceLanguage, string $targetLanguage, string $message): ?string {
    if (empty($this->_apiKey)) {
      return null;
    }

    $url = new Url(self::ENDPOINT);
    $url->setQuery([
      'format' => 'html',
      'key'    => $this->_apiKey,
      'q'      => $message,
      'source' => $sourceLanguage,
      'target' => $targetLanguage,
    ]);

    $handle = curl_init((string)$url);
    if ($handle === false) {
      return null;
    }

    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($handle);
    $responseDecoded = Json::decode($response);
    $responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    curl_close($handle);

    if ($responseCode != 200) {
      return null;
    }

    return ArrayHelper::getValue(
      $responseDecoded,
      ['data', 'translations', 0, 'translatedText']
    );
  }


  // Static methods
  // --------------

  /**
   * @return string
   */
  static function getDisplayName(): string {
    return 'Google Translator';
  }

  /**
   * @return string
   */
  static function getHandle(): string {
    return 'google';
  }

  /**
   * @inheritDoc
   */
  static function getSettingsHtml(): string {
    return Craft::$app->getView()->renderTemplate(
      'contentfield/_config-translator-google',
      self::getSettings()
    );
  }
}
