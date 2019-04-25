<?php

namespace lenz\contentfield\utilities\oembed;

/**
 * Class Provider
 */
class Provider
{
  /**
   * @var Endpoint[]
   */
  public $endpoints;

  /**
   * @var string
   */
  public $providerName;

  /**
   * @var string
   */
  public $providerUrl;

  /**
   * @var string
   */
  public $searchName;

  /**
   * @var Provider[]
   */
  private static $allProviders;

  /**
   * @var string
   */
  const DEFINITIONS_URL = 'https://oembed.com/providers.json';

  /**
   * @var array
   */
  static $CUSTOM_DEFINITIONS = [
    'youtube' => [
      "provider_name" => "YouTube",
      "provider_url" => "https://www.youtube.com/",
      "endpoints" => [
        [
          "schemes" => [
            "http://youtu.be/*",
            "http://www.youtube.com/*",
            "https://youtu.be/*",
            "https://www.youtube.com/*",
          ],
          "url" => "https://www.youtube.com/oembed",
        ]
      ]
    ]
  ];


  /**
   * Provider constructor.
   * @param array $config
   */
  public function __construct(array $config = []) {
    $this->providerName = array_key_exists('provider_name', $config)
      ? (string)$config['provider_name']
      : '';

    $this->providerUrl = array_key_exists('provider_url', $config)
      ? (string)$config['provider_url']
      : '';

    if (array_key_exists('endpoints', $config) && is_array($config['endpoints'])) {
      foreach ($config['endpoints'] as $endpoints) {
        $this->endpoints[] = new Endpoint($this, $endpoints);
      }
    }

    $this->searchName = strtolower($this->providerName);
  }

  /**
   * @return array
   */
  public function getEditorData() {
    $endpoints = array();
    foreach ($this->endpoints as $endpoint) {
      $endpoints[] = $endpoint->getEditorData();
    }

    return array(
      'endpoints'    => $endpoints,
      'providerName' => $this->providerName,
      'providerUrl'  => $this->providerUrl,
    );
  }

  /**
   * @param string $url
   * @return Endpoint|null
   */
  public function getEndpoint($url) {
    foreach ($this->endpoints as $endpoint) {
      if ($endpoint->matches($url)) {
        return $endpoint;
      }
    }

    return null;
  }

  /**
   * @param string $name
   * @return Provider|null
   */
  static public function findProvider($name) {
    $name = strtolower($name);
    if (array_key_exists($name, self::$CUSTOM_DEFINITIONS)) {
      return new Provider(self::$CUSTOM_DEFINITIONS[$name]);
    }

    foreach (self::getAllProviders() as $provider) {
      if ($provider->searchName === $name) {
        return $provider;
      }
    }

    return null;
  }

  /**
   * @return Provider[]
   */
  static public function getAllProviders() {
    if (!isset(self::$allProviders)) {
      $providers = array();
      $rows = OEmbed::fetchJson(self::DEFINITIONS_URL);

      if (is_array($rows)) {
        foreach ($rows as $row) {
          $providers[] = new Provider($row);
        }
      }

      self::$allProviders = $providers;
    }

    return self::$allProviders;
  }
}
