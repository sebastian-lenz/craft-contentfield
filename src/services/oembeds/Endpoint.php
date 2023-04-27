<?php

namespace lenz\contentfield\services\oembeds;

use lenz\contentfield\events\OEmbedUrlEvent;
use lenz\contentfield\Plugin;
use lenz\contentfield\services\OEmbeds;
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

    $this->embedClass = array_key_exists('embed_class', $config)
      ? (string)$config['embed_class']
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

    $event = new OEmbedUrlEvent([
      'endpoint' => $this,
      'embedClass' => $this->embedClass,
      'url' => $endpoint,
    ]);

    $oembeds = Plugin::getInstance()->oembeds;
    $oembeds->trigger(OEmbeds::EVENT_OEMBED_URL, $event);
    $data = $event->data ?? $oembeds->fetchJson((string)$event->url);

    return is_null($data)
      ? null
      : new $event->embedClass($this, $url, $data);
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
