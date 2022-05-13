<?php

namespace lenz\contentfield\models\fields;

use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\OEmbedValue;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\Plugin;
use lenz\contentfield\services\oembeds\Endpoint;
use lenz\contentfield\services\oembeds\OEmbed;
use lenz\contentfield\services\oembeds\Provider;

/**
 * Class OEmbedField
 */
class OEmbedField extends AbstractField
{
  /**
   * @var Provider[]
   */
  public array $providers = [];

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

      $providers = [];
      foreach ($config['providers'] as $source) {
        if (is_string($source)) {
          $source = Plugin::getInstance()->oembeds->findProvider($source);
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
  public function createValue(mixed $data, ValueInterface $parent = null): OEmbedValue {
    return new OEmbedValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorValue(mixed $value): ?array {
    if (!($value instanceof OEmbedValue)) {
      return null;
    }

    $url = $value->getUrl();
    return array(
      'url'  => $url,
      'info' => $this->getOEmbed($url),
    );
  }

  /**
   * @param string $url
   * @return Endpoint|null
   */
  public function getEndpoint(string $url): ?Endpoint {
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
  public function getOEmbed(string $url): ?OEmbed {
    $endpoint = $this->getEndpoint($url);
    return is_null($endpoint)
      ? null
      : $endpoint->getOEmbed($url);
  }

  /**
   * @inheritDoc
   */
  public function getSerializedValue(mixed $value): ?string {
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
  static public function expandFieldConfig(array &$config): void {
    if ($config['type'] === 'youtube') {
      $config = array(
        'type'      => self::NAME,
        'providers' => array('YouTube'),
      ) + $config;
    }
  }
}
