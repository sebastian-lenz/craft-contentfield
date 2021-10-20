<?php

namespace lenz\contentfield\services\translators;

use Craft;
use craft\helpers\Json;
use lenz\craft\utils\helpers\ArrayHelper;
use lenz\craft\utils\models\Url;

/**
 * Class AzureTranslator
 */
class AzureTranslator extends AbstractTranslator
{
  /**
   * @var string
   */
  private $_endpoint = self::DEFAULT_ENDPOINT;

  /**
   * @var string
   */
  private $_subscriptionKey;

  /**
   * @var string
   */
  private $_subscriptionRegion;

  /**
   * The url of the API endpoint.
   */
  const DEFAULT_ENDPOINT = 'https://api.cognitive.microsofttranslator.com/translate';


  /**
   * @return string
   */
  public function getEndpoint(): string {
    return empty($this->_endpoint) ? self::DEFAULT_ENDPOINT : $this->_endpoint;
  }

  /**
   * @return string
   */
  public function getSubscriptionKey(): string {
    return $this->_subscriptionKey;
  }

  /**
   * @return string
   */
  public function getSubscriptionRegion(): string {
    return $this->_subscriptionRegion;
  }

  /**
   * @param string $value
   */
  public function setEndpoint(string $value) {
    $this->_endpoint = $value;
  }

  /**
   * @param string $value
   */
  public function setSubscriptionKey(string $value) {
    $this->_subscriptionKey = $value;
  }

  /**
   * @param string $value
   */
  public function setSubscriptionRegion(string $value) {
    $this->_subscriptionRegion = $value;
  }

  /**
   * @inheritDoc
   */
  public function translate($sourceLanguage, $targetLanguage, $message) {
    $endpoint = Craft::parseEnv($this->getEndpoint());
    $subscriptionKey = Craft::parseEnv($this->getSubscriptionKey());
    if (empty($endpoint) || empty($subscriptionKey)) {
      return null;
    }

    $body = Json::encode([
      ['text' => $message]
    ]);

    $headers = [
      'Ocp-Apim-Subscription-Key: ' . $subscriptionKey,
      'Content-Type: application/json',
      'Content-Length: ' . strlen($body),
    ];

    $subscriptionRegion = $this->getSubscriptionRegion();
    if (!empty($subscriptionRegion)) {
      $headers[] = 'Ocp-Apim-Subscription-Region: ' . $subscriptionRegion;
    }

    $url = new Url($endpoint);
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

    return ArrayHelper::get(
      $responseDecoded,
      [0, 'translations', 0, 'text']
    );
  }


  // Static methods
  // --------------

  /**
   * @return string
   */
  static function getDisplayName(): string {
    return 'Azure Text Translation';
  }

  /**
   * @return string
   */
  static function getHandle(): string {
    return 'azure';
  }

  /**
   * @inheritDoc
   */
  static function getSettingsHtml(): ?string {
    return Craft::$app->getView()->renderTemplate(
      'contentfield/_config-translator-azure',
      self::getSettings()
    );
  }
}
