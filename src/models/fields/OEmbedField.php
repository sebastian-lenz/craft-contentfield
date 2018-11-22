<?php

namespace contentfield\models\fields;

use craft\base\ElementInterface;

use contentfield\models\values\OEmbedValue;
use contentfield\models\values\AbstractValue;
use contentfield\utilities\oembed\Endpoint;
use contentfield\utilities\oembed\OEmbed;
use contentfield\utilities\oembed\Provider;

/**
 * Class OEmbedField
 */
class OEmbedField extends AbstractField
{
  /**
   * @var Provider[]
   */
  public $providers = array();

  /**
   * @inheritdoc
   */
  const NAME = 'oembed';


  /**
   * @inheritdoc
   */
  public function __construct(array $config = []) {
    if (array_key_exists('providers', $config)) {
      if (!is_array($config['providers'])) {
        $config['providers'] = explode(',', (string)$config['providers']);
      }

      $providers = array();
      foreach ($config['providers'] as $source) {
        if (is_string($source)) {
          $source = Provider::findProvider($source);
        }

        if ($source instanceof Provider) {
          $providers[] = $source;
        } else if (is_array($source)) {
          $providers[] = new Provider($source);
        }
      }

      $config['providers'] = $providers;
    }

    parent::__construct($config);
  }

  /**
   * @inheritdoc
   */
  public function createValue($data, AbstractValue $parent) {
    return new OEmbedValue($data, $parent, $this);
  }

  /**
   * @param string $url
   * @return Endpoint|null
   */
  public function getEndpoint($url) {
    foreach ($this->providers as $provider) {
      $endpoint = $provider->getEndpoint($url);
      if (!is_null($endpoint)) {
        return $endpoint;
      }
    }

    return null;
  }

  /**
   * @param string $url
   * @return OEmbed|null
   */
  public function getOEmbed($url) {
    $endpoint = $this->getEndpoint($url);
    return is_null($endpoint)
      ? null
      : $endpoint->getOEmbed($url);
  }

  /**
   * @inheritdoc
   */
  static function expandFieldConfig(&$config) {
    if ($config['type'] === 'youtube') {
      $config = array(
        'type'      => self::NAME,
        'providers' => array('YouTube'),
      ) + $config;
    }
  }
}
