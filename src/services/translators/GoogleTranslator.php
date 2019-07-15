<?php

namespace lenz\contentfield\services\translators;

use Craft;
use craft\helpers\ArrayHelper;
use craft\helpers\Json;
use lenz\contentfield\utilities\Url;

/**
 * Class GoogleTranslator
 */
class GoogleTranslator extends AbstractTranslator
{
  /**
   * @var string
   */
  private $_apiKey;

  /**
   * The url of the API endpoint.
   */
  const ENDPOINT = 'https://translation.googleapis.com/language/translate/v2';


  /**
   * @return string
   */
  public function getApiKey() {
    return $this->_apiKey;
  }

  /**
   * @param string $value
   */
  public function setApiKey($value) {
    $this->_apiKey = (string)$value;
  }

  /**
   * @inheritDoc
   */
  public function translate($sourceLanguage, $targetLanguage, $message) {
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
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($handle);
    $responseDecoded = Json::decode($response, true);
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
  static function getDisplayName() {
    return 'Google Translator';
  }

  /**
   * @return string
   */
  static function getHandle() {
    return 'google';
  }

  /**
   * @inheritDoc
   */
  static function getSettingsHtml() {
    return Craft::$app->getView()->renderTemplate(
      'contentfield/_config-translator-google',
      self::getSettings()
    );
  }
}
