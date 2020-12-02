<?php

namespace lenz\contentfield\services\translators;

use Craft;
use craft\helpers\ArrayHelper;
use craft\helpers\Json;
use lenz\craft\utils\models\Url;

/**
 * Class AzureTranslator
 */
class AzureTranslator extends AbstractTranslator
{
  /**
   * @var string
   */
  private $_subscriptionKey;

  /**
   * The url of the API endpoint.
   */
  const ENDPOINT = 'https://api.cognitive.microsofttranslator.com/translate';


  /**
   * @return string
   */
  public function getSubscriptionKey() {
    return $this->_subscriptionKey;
  }

  /**
   * @param string $value
   */
  public function setSubscriptionKey($value) {
    $this->_subscriptionKey = (string)$value;
  }

  /**
   * @inheritDoc
   */
  public function translate($sourceLanguage, $targetLanguage, $message) {
    if (empty($this->_subscriptionKey)) {
      return null;
    }

    $body = Json::encode([
      ['text' => $message]
    ]);

    $headers = [
      'Ocp-Apim-Subscription-Key: ' . $this->_subscriptionKey,
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
    if ($handle === false) {
      return null;
    }

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

    return ArrayHelper::getValue(
      $responseDecoded,
      [0, 'translations', 0, 'text']
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
