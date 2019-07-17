<?php

namespace lenz\contentfield\utilities;

use Craft;
use craft\helpers\Json;
use craft\web\assets\cp\CpAsset;
use craft\web\View;
use Exception;
use lenz\contentfield\assets\field\ContentFieldAsset;

/**
 * Class IconUtility
 */
class IconPage extends AbstractPage
{
  /**
   * @inheritDoc
   */
  public function contentHtml() {
    $view = Craft::$app->getView();

    return $view->renderTemplate('contentfield/_utility-icons', [
      'craftIcons'    => $this->getCraftIcons($view),
      'materialIcons' => $this->getMaterialIcons($view),
    ]);
  }

  /**
   * @inheritDoc
   */
  public function getHandle() {
    return 'icons';
  }

  /**
   * @inheritDoc
   */
  public function getLabel() {
    return 'Icons';
  }


  // Private methods
  // ---------------

  /**
   * @param View $view
   * @return array
   */
  private function getCraftIcons(View $view) {
    /** @var CpAsset $bundle */
    try {
      $view->registerAssetBundle(CpAsset::class);
      $bundle = $view->getAssetManager()->getBundle(CpAsset::class);
    } catch (Exception $e) {
      return array();
    }

    $result = array();
    $path = $bundle->sourcePath . '/../src/craft-font/selection.json';
    $data = Json::decode(file_get_contents($path));

    foreach ($data['icons'] as $icon) {
      $ligatures = explode(',', $icon['properties']['ligatures']);
      $result[] = trim($ligatures[0]);
    }

    sort($result);
    return $result;
  }

  /**
   * @param View $view
   * @return array
   */
  private function getMaterialIcons(View $view) {
    /** @var ContentFieldAsset $bundle */
    try {
      $view->registerAssetBundle(ContentFieldAsset::class);
      $bundle = $view->getAssetManager()->getBundle(ContentFieldAsset::class);
    } catch (Exception $e) {
      return array();
    }

    $result = array();
    $path = $bundle->sourcePath . '/fonts/codepoints';
    preg_match_all('/^([^ ]+)/m', file_get_contents($path), $matches);

    foreach ($matches[0] as $icon) {
      $result[] = $icon;
    }

    sort($result);
    return $result;
  }
}
