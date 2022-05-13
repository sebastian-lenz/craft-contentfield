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
   * @var class-string<OEmbed>
   */
  public string $embedClass;

  /**
   * @var Provider
   */
  public Provider $provider;

  /**
   * @var string[]
   */
  public array $schemes = [];

  /**
   * @var string
   */
  public string $url;


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
  public function getEditorData(): array {
    return array(
      'schemes' => $this->schemes,
      'url'     => $this->url,
    );
  }

  /**
   * @param string $url
   * @return OEmbed|null
   */
  public function getOEmbed(string $url): ?OEmbed {
    $endpoint = new Url(str_replace('{format}', 'json', $this->url));
    $endpoint->setQuery(array_merge($endpoint->getQuery(), [
      'format' => 'json',
      'url' => $url,
    ]));

    $embedClass = $this->embedClass;
    $data = Plugin::getInstance()
      ->oembeds
      ->fetchJson((string)$endpoint);

    return is_null($data)
      ? null
      : new $embedClass($this, $url, $data);
  }

  /**
   * @param string $url
   * @return bool
   */
  public function matches(string $url): bool {
    foreach ($this->schemes as $schema) {
      if (fnmatch($schema, $url)) {
        return true;
      }
    }

    return false;
  }
}
