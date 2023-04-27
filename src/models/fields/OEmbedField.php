<?php

namespace lenz\contentfield\models\fields;

use lenz\contentfield\models\values\OEmbedValue;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\Plugin;
use lenz\contentfield\services\oembeds\Endpoint;
use lenz\contentfield\services\oembeds\OEmbed;
use lenz\contentfield\services\oembeds\Provider;
use lenz\craft\utils\helpers\ArrayHelper;

/**
 * Class OEmbedField
 */
class OEmbedField extends AbstractField
{
  /**
   * @var Provider[]
   */
  private array $_providers = [];

  /**
   * @inheritdoc
   */
  const NAME = 'oembed';


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
    return [
      'url' => $url,
      'info' => $this->getOEmbed($url),
    ];
  }

  /**
   * @param string $url
   * @return Endpoint|null
   */
  public function getEndpoint(string $url): ?Endpoint {
    return ArrayHelper::firstResult($this->_providers,
      fn($provider) => $provider->getEndpoint($url)
    );
  }

  /**
   * @param string $url
   * @return OEmbed|null
   */
  public function getOEmbed(string $url): ?OEmbed {
    return $this->getEndpoint($url)?->getOEmbed($url);
  }

  /**
   * @return Provider[]
   */
  public function getProviders(): array {
    return $this->_providers;
  }

  /**
   * @inheritDoc
   */
  public function getSerializedValue(mixed $value): ?string {
    return $value instanceof OEmbedValue ? $value->getUrl() : null;
  }

  /**
   * @param array|string $value
   * @return void
   */
  public function setProviders(array|string $value): void {
    if (!is_array($value)) {
      $value = array_filter(array_map('trim', explode(',', $value)));
    }

    $oEmbeds = Plugin::getInstance()->oembeds;
    $this->_providers = array_filter(array_map(function(mixed $provider) use ($oEmbeds) {
      if ($provider instanceof Provider) {
        return $provider;
      } elseif (is_string($provider)) {
        return $oEmbeds->findProvider(trim($provider));
      } elseif (is_array($provider)) {
        return new Provider($provider);
      } else {
        return null;
      }
    }, $value));
  }


  // Static methods
  // --------------

  /**
   * @inheritdoc
   */
  static public function expandFieldConfig(array &$config): void {
    if ($config['type'] === 'youtube') {
      $config = [
        ...$config,
        'type' => self::NAME,
        'providers' => ['YouTube'],
      ];
    }
  }
}
