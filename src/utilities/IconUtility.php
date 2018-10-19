<?php

namespace contentfield\utilities;

use craft\base\Utility;
use craft\helpers\Json;
use craft\web\assets\cp\CpAsset;
use craft\web\View;
use yii\base\Exception;

/**
 * Class IconUtility
 * @package contentfield\utilities
 */
class IconUtility extends Utility
{
  /**
   * @inheritdoc
   */
  public static function contentHtml(): string {
    $view = \Craft::$app->getView();

    try {
      return $view->renderTemplate('contentfield/_icons', array(
        'craftIcons'    => self::getCraftIcons($view),
        'materialIcons' => self::getMaterialIcons($view),
      ));
    } catch (\Exception $e) {
      return 'Unavailable';
    }
  }

  /**
   * @param View $view
   * @return array
   */
  public static function getCraftIcons(View $view) {
    /** @var CpAsset $bundle */
    try {
      $view->registerAssetBundle(CpAsset::class);
      $bundle = $view->getAssetManager()->getBundle(CpAsset::class);
    } catch (\Exception $e) {
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
  public static function getMaterialIcons(View $view) {
    /** @var CpAssetBundle $bundle */
    try {
      $view->registerAssetBundle(CpAssetBundle::class);
      $bundle = $view->getAssetManager()->getBundle(CpAssetBundle::class);
    } catch (\Exception $e) {
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

  /**
   * @inheritdoc
   */
  public static function iconPath() {
    return \Craft::getAlias('@app/icons/photo.svg');
  }

  /**
   * @inheritdoc
   */
  public static function id(): string {
    return 'tcf-icons';
  }

  /**
   * @inheritdoc
   */
  public static function displayName(): string {
    return \Craft::t('contentfield', 'Icons');
  }
}
