<?php

namespace lenz\contentfield\services;

use craft\helpers\Json;
use lenz\contentfield\services\oembeds\Provider;
use Throwable;
use yii\base\Component;
use yii\caching\FileCache;

/**
 * Class OEmbeds
 */
class OEmbeds extends Component
{
  /**
   * @var Provider[]
   */
  private $_allProviders;
  /**
   * @var FileCache
   */
  private $cache;

  /**
   * @var array
   */
  static $CUSTOM_DEFINITIONS = [
    'podigee' => [
      'provider_name' => 'Podigee',
      'provider_url' => 'https://www.podigee.com/',
      'endpoints' => [
        [
          'schemes' => [
            'http://*.podigee.io/*',
            'https://*.podigee.io/*',
          ],
          'url' => 'https://embed.podigee.com/oembed',
        ]
      ]
    ],
    'youtube' => [
      'provider_name' => 'YouTube',
      'provider_url' => 'https://www.youtube.com/',
      'endpoints' => [
        [
          'embedClass' => oembeds\YouTubeEmbed::class,
          'schemes' => [
            'http://youtu.be/*',
            'http://www.youtube.com/*',
            'https://youtu.be/*',
            'https://www.youtube.com/*',
          ],
          'url' => 'https://www.youtube.com/oembed',
        ]
      ]
    ]
  ];

  /**
   * Default cache duration.
   */
  const CACHE_DURATION = 60 * 60 * 24 * 30;

  /**
   * @var string
   */
  const DEFINITIONS_URL = 'https://oembed.com/providers.json';


  /**
   * @param string $url
   * @return array|null
   */
  public function fetchJson($url) {
    $cache  = $this->getCache();
    $result = null;

    try {
      $response = $cache->get($url);
      if ($response !== false) {
        $result = Json::decode($response);
      }
    } catch (Throwable $error) {}

    if (is_null($result)) {
      try {
        $response = $this->fetch($url);
        $result   = Json::decode($response);
        $duration = isset($result['cache_age'])
          ? $result['cache_age']
          : self::CACHE_DURATION;

        $cache->set($url, $response, $duration);
      } catch (Throwable $error) {}
    }

    return is_array($result) ? $result : null;
  }

  /**
   * @param string $name
   * @return Provider|null
   */
  public function findProvider($name) {
    $name = strtolower($name);
    if (array_key_exists($name, self::$CUSTOM_DEFINITIONS)) {
      return new Provider(self::$CUSTOM_DEFINITIONS[$name]);
    }

    foreach ($this->getAllProviders() as $provider) {
      if ($provider->searchName === $name) {
        return $provider;
      }
    }

    return null;
  }


  // Private methods
  // ---------------

  /**
   * @param string $url
   * @return mixed
   */
  private function fetch($url) {
    $channel = curl_init();
    if ($channel === false) {
      return null;
    }

    curl_setopt($channel,CURLOPT_URL, $url);
    curl_setopt($channel,CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($channel,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($channel);
    if (curl_errno($channel)) {
      $result = null;
    } else {
      $resultCode = curl_getinfo($channel, CURLINFO_HTTP_CODE);
      if ($resultCode != 200) {
        $result = null;
      }
    }

    curl_close($channel);
    return $result;
  }

  /**
   * @return Provider[]
   */
  private function getAllProviders() {
    if (!isset($this->_allProviders)) {
      $providers = [];
      $rows = $this->fetchJson(self::DEFINITIONS_URL);

      if (is_array($rows)) {
        foreach ($rows as $row) {
          $providers[] = new Provider($row);
        }
      }

      $this->_allProviders = $providers;
    }

    return $this->_allProviders;
  }

  /**
   * @return FileCache
   */
  private function getCache() {
    if (!isset($this->cache)) {
      $this->cache = new FileCache([
        'cachePath' => '@runtime/oembed'
      ]);
    }

    return $this->cache;
  }
}
