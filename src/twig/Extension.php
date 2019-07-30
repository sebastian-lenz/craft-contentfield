<?php

namespace lenz\contentfield\twig;

use craft\elements\Asset;
use craft\elements\db\AssetQuery;
use craft\helpers\Template;
use Exception;
use lenz\contentfield\Plugin;
use lenz\contentfield\twig\nodeVisitors\DisplayNodeVisitor;
use lenz\contentfield\twig\tokenParsers\DisplayTokenParser;
use lenz\contentfield\twig\tokenParsers\SiblingsTokenParser;
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
      new DisplayTokenParser(),
      new SiblingsTokenParser(),
    ];
  }

  public function getNodeVisitors() {
    return [
      new DisplayNodeVisitor()
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
   * @return string|null
   * @throws Exception
   */
  static function imageTag($asset, $config) {
    if ($asset instanceof AssetQuery) {
      $asset = $asset->one();
    }

    if (is_array($asset) && count($asset) > 0) {
      $asset = $asset[0];
    }

    return $asset instanceof Asset
      ? Template::raw(Plugin::getInstance()
        ->imageTags
        ->render($asset, $config))
      : null;
  }
}
