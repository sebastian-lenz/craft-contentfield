<?php

namespace lenz\contentfield\services\oembeds;

/**
 * Class Provider
 *
 * Represents a single OEmbed provider (e.g. YouTube)
 */
class Provider
{
  /**
   * @var Endpoint[]
   */
  public array $endpoints;

  /**
   * @var string
   */
  public string $providerName;

  /**
   * @var string
   */
  public string $providerUrl;

  /**
   * @var string
   */
  public string $searchName;


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
  public function getEditorData(): array {
    $endpoints = [];
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
  public function getEndpoint(string $url): ?Endpoint {
    foreach ($this->endpoints as $endpoint) {
      if ($endpoint->matches($url)) {
        return $endpoint;
      }
    }

    return null;
  }
}
