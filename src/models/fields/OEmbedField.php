<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;

use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\OEmbedValue;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\utilities\oembed\Endpoint;
use lenz\contentfield\utilities\oembed\OEmbed;
use lenz\contentfield\utilities\oembed\Provider;

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
  public function __construct(AbstractSchema $schema = null, array $config = []) {
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

    parent::__construct($schema, $config);
  }

  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent = null) {
    return new OEmbedValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorValue($value) {
    if (!($value instanceof OEmbedValue)) {
      return null;
    }

    return array(
      'url'  => $value->getUrl(),
      'info' => $value->getOEmbed(),
    );
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
   * @inheritDoc
   */
  public function getSerializedValue($value) {
    if (!($value instanceof OEmbedValue)) {
      return null;
    }

    return $value->getUrl();
  }


  // Static methods
  // --------------

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
