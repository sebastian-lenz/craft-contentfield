<?php

namespace lenz\contentfield\services\translators;

use Craft;
use craft\helpers\ArrayHelper;
use craft\helpers\Json;
use lenz\contentfield\utilities\Url;

/**
 * Class AzureTranslator
 */
class AzureTranslator extends AbstractTranslator
{
  /**
   * @var string
   */
  public $subscriptionKey;

  /**
   * The url of the API endpoint.
   */
  const ENDPOINT = 'https://api.cognitive.microsofttranslator.com/translate';


  /**
   * @inheritDoc
   */
  public function translate($sourceLanguage, $targetLanguage, $message) {
    if (empty($this->endpoint) || empty($this->subscriptionKey)) {
      return null;
    }

    $body = Json::encode([
      ['text' => $message]
    ]);

    $headers = [
      'Ocp-Apim-Subscription-Key: ' . $this->subscriptionKey,
      'Content-Type: application/json',
      'Content-Length: ' . strlen($body),
    ];

    $url = new Url(self::ENDPOINT);
    $url->setQuery([
      'api-version' => '3.0',
      'from'        => $sourceLanguage,
      'to'          => $targetLanguage,
      'textType'    => 'html'
    ]);

    $handle = curl_init((string)$url);
    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $body);
    curl_setopt($handle, CURLOPT_POST, true);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($handle);
    $responseDecoded = Json::decode($response, true);
    $responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    curl_close($handle);

    if ($responseCode != 200) {
      return null;
    }

    ArrayHelper::getValue(
      $responseDecoded,
      [0, 'translations', 'text']
    );
  }


  // Static methods
  // --------------

  /**
   * @return string
   */
  static function getDisplayName() {
    return 'Azure Text Translation';
  }

  /**
   * @return string
   */
  static function getHandle() {
    return 'azure';
  }

  /**
   * @inheritDoc
   */
  static function getSettingsHtml() {
    return Craft::$app->getView()->renderTemplate(
      'contentfield/_config-translator-azure',
      self::getSettings()
    );
  }
}
