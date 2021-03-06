<?php

namespace lenz\contentfield\services\oembeds;

use lenz\contentfield\Plugin;
use lenz\craft\utils\models\Url;

/**
 * Class Endpoint
 *
 * Represents a single endpoint offered by a provider.
 */
class Endpoint
{
  /**
   * @var string
   */
  public $embedClass;

  /**
   * @var Provider
   */
  public $provider;

  /**
   * @var string[]
   */
  public $schemes = [];

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

    $this->embedClass = array_key_exists('embedClass', $config)
      ? (string)$config['embedClass']
      : OEmbed::class;

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
    $endpoint = new Url(str_replace('{format}', 'json', $this->url));
    $endpoint->setQuery([
      'format' => 'json',
      'url'    => $url,
    ] + $endpoint->getQuery());

    $data = Plugin::getInstance()
      ->oembeds
      ->fetchJson((string)$endpoint);

    $embedClass = $this->embedClass;

    return is_null($data)
      ? null
      : new $embedClass($this, $url, $data);
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
