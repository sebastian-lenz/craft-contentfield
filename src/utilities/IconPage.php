<?php

namespace lenz\contentfield\utilities;

use Craft;
use craft\helpers\ArrayHelper;
use craft\helpers\Json;
use craft\web\assets\cp\CpAsset;
use craft\web\View;
use Exception;
use GuzzleHttp\Client;
use lenz\contentfield\assets\field\ContentFieldAsset;

/**
 * Class IconUtility
 */
class IconPage extends AbstractPage
{
  /**
   * @var string
   */
  const CRAFT_FONT_URL = 'https://raw.githubusercontent.com/craftcms/cms/develop/src/web/assets/cp/src/craft-font/selection.json';


  /**
   * @inheritDoc
   */
  public function contentHtml() : string {
    $view = Craft::$app->getView();

    return $view->renderTemplate('contentfield/_utility-icons', [
      'craftIcons'    => $this->getCraftIcons($view),
      'materialIcons' => $this->getMaterialIcons($view),
    ]);
  }

  /**
   * @inheritDoc
   */
  public function getHandle() : string {
    return 'icons';
  }

  /**
   * @inheritDoc
   */
  public function getIcon(): string {
    return 'asset';
  }

  /**
   * @inheritDoc
   */
  public function getLabel() : string {
    return 'Icons';
  }


  // Private methods
  // ---------------

  /**
   * @param View $view
   * @return array
   * @throws Exception
   */
  private function getCraftIcons(View $view): array {
    try {
      $view->registerAssetBundle(CpAsset::class);
      $bundle = $view->getAssetManager()->getBundle(CpAsset::class);
    } catch (Exception) {
      return [];
    }

    $result = [];
    $path = $bundle->sourcePath . '/../src/craft-font/selection.json';
    if (file_exists($path)) {
      $data = Json::decode(file_get_contents($path));
    } else {
      $data = Craft::$app->cache->getOrSet(__METHOD__, function() {
        $client = new Client();
        $response = $client->request('GET', self::CRAFT_FONT_URL);
        return Json::decode($response->getBody()->getContents());
      });
    }

    foreach ($data['icons'] as $icon) {
      $ligatures = ArrayHelper::getValue($icon, ['properties', 'ligatures']);
      if (is_null($ligatures)) {
        continue;
      }

      $ligatures = explode(',', $ligatures);
      $result[] = trim($ligatures[0]);
    }

    sort($result);
    return $result;
  }

  /**
   * @param View $view
   * @return array
   */
  private function getMaterialIcons(View $view): array {
    try {
      $view->registerAssetBundle(ContentFieldAsset::class);
      $bundle = $view->getAssetManager()->getBundle(ContentFieldAsset::class);
    } catch (Exception) {
      return [];
    }

    $result = [];
    $path = $bundle->sourcePath . '/fonts/codepoints';
    preg_match_all('/^([^ ]+)/m', file_get_contents($path), $matches);

    foreach ($matches[0] as $icon) {
      $result[] = $icon;
    }

    sort($result);
    return $result;
  }
}
