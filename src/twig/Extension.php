<?php

namespace lenz\contentfield\twig;

use craft\elements\Asset;
use craft\elements\db\AssetQuery;
use craft\helpers\Template;
use Exception;
use Illuminate\Support\Collection;
use lenz\contentfield\models\values\ReferenceValue;
use lenz\contentfield\Plugin;
use lenz\contentfield\twig\nodeVisitors\DisplayNodeVisitor;
use lenz\contentfield\twig\tokenParsers\DisplayTokenParser;
use lenz\contentfield\twig\tokenParsers\SiblingsTokenParser;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFunction;

/**
 * Class Extension
 */
class Extension extends AbstractExtension
{
  /**
   * @inheritDoc
   */
  public function getTokenParsers(): array {
    return [
      new DisplayTokenParser(),
      new SiblingsTokenParser(),
    ];
  }

  /**
   * @inheritDoc
   */
  public function getNodeVisitors(): array {
    return [
      new DisplayNodeVisitor()
    ];
  }

  /**
   * @inheritDoc
   */
  public function getFunctions(): array {
    return [
      new TwigFunction('imageTag', [Extension::class, 'imageTag']),
    ];
  }


  // Static methods
  // --------------

  /**
   * @param mixed $asset
   * @param array|string $config
   * @return Markup|null
   * @throws Exception
   */
  static function imageTag(mixed $asset, array|string $config): ?Markup {
    echo '';
    if ($asset instanceof AssetQuery) {
      $asset = $asset->one();
    } elseif ($asset instanceof ReferenceValue) {
      $asset = $asset->getFirst();
    } elseif ($asset instanceof Collection) {
      $asset = $asset->first();
    } elseif (is_array($asset) && count($asset) > 0) {
      $asset = $asset[0];
    }

    $html = $asset instanceof Asset
      ? Plugin::getInstance()->imageTags->render($asset, $config)
      : null;

    return empty($html) ? null : Template::raw($html);
  }
}
