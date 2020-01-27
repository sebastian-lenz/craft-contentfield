<?php

namespace lenz\contentfield\services\oembeds;

use lenz\contentfield\helpers\UrlHelper;
use lenz\contentfield\Plugin;

/**
 * Class Endpoint
 *
 * Represents a single endpoint offered by a provider.
 */
class Endpoint
{
  /**
   * @var Provider
   */
  public $provider;

  /**
   * @var string[]
   */
  public $schemes = array();

  /**
   * @var string
   */
  public $url;


  /**
   * Endpoint constructor.
   *
   * @param Provider $provider
   * @param array $config
   */
  public function __construct(Provider $provider, array $config = []) {
    $this->provider = $provider;
    $this->url = array_key_exists('url', $config)
      ? (string)$config['url']
      : '';

    if (array_key_exists('schemes', $config) && is_array($config['schemes'])) {
      foreach ($config['schemes'] as $scheme) {
        $this->schemes[] = (string)$scheme;
      }
    }
  }

  /**
   * @return array
   */
  public function getEditorData() {
    return array(
      'schemes' => $this->schemes,
      'url'     => $this->url,
    );
  }

  /**
   * @param string $url
   * @return OEmbed|null
   */
  public function getOEmbed($url) {
    $endpoint = new UrlHelper(str_replace('{format}', 'json', $this->url));
    $endpoint->setQuery([
      'format' => 'json',
      'url'    => $url,
    ] + $endpoint->getQuery());

    $data = Plugin::getInstance()
      ->oembeds
      ->fetchJson((string)$endpoint);

    return is_null($data)
      ? null
      : new OEmbed($data);
  }

  /**
   * @param string $url
   * @return bool
   */
  public function matches($url) {
    foreach ($this->schemes as $schema) {
      if (fnmatch($schema, $url)) {
        return true;
      }
    }

    return false;
  }
}
