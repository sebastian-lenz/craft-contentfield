<?php

namespace lenz\contentfield\utilities\twig;

use craft\elements\Asset;
use craft\elements\db\AssetQuery;
use craft\helpers\Template;
use lenz\contentfield\Plugin;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class Extension
 */
class Extension extends AbstractExtension
{
  /**
   * @inheritDoc
   */
  public function getTokenParsers() {
    return [
      new DisplayTokenParser()
    ];
  }

  /**
   * @inheritDoc
   */
  public function getFunctions() {
    return [
      new TwigFunction('imageTag', [Extension::class, 'imageTag']),
    ];
  }

  /**
   * @param Asset $asset
   * @param string|array $config
   * @param array|null $extraConfig
   * @return string|null
   * @throws \Exception
   */
  static function imageTag($asset, $config, $extraConfig = null) {
    if ($asset instanceof AssetQuery) {
      $asset = $asset->one();
    }

    if (is_array($asset) && count($asset) > 0) {
      $asset = $asset[0];
    }

    return $asset instanceof Asset
      ? Template::raw(Plugin::getInstance()
        ->imageTags
        ->render($asset, $config, $extraConfig))
      : null;
  }
}
