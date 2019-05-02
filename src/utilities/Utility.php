<?php

namespace lenz\contentfield\utilities;

use Craft;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use craft\elements\GlobalSet;
use craft\elements\Tag;
use craft\elements\User;
use craft\helpers\Json;
use craft\web\assets\cp\CpAsset;
use craft\web\View;
use Exception;
use lenz\contentfield\assets\field\ContentFieldAsset;

/**
 * Class Utility
 */
class Utility extends craft\base\Utility
{
  /**
   * @inheritdoc
   */
  public static function contentHtml(): string {
    $view = Craft::$app->getView();
    $tabs = self::getTabs();
    $selectedTab = isset($_GET['tab']) && array_key_exists($_GET['tab'], $tabs)
      ? $_GET['tab']
      : array_keys($tabs)[0];

    $template = 'contentfield/_utility-' . $selectedTab;

    try {
      return $view->renderTemplate($template, array(
        'craftIcons'    => self::getCraftIcons($view),
        'materialIcons' => self::getMaterialIcons($view),
        'selectedTab'   => $selectedTab,
        'sourceTypes'   => self::getSourceTypes(),
        'tabs'          => $tabs,
      ));
    } catch (Exception $e) {
      return 'Unavailable';
    }
  }

  /**
   * @inheritdoc
   */
  public static function iconPath() {
    return Craft::getAlias('@app/icons/photo.svg');
  }

  /**
   * @inheritdoc
   */
  public static function id(): string {
    return 'tcf-utilities';
  }

  /**
   * @inheritdoc
   */
  public static function displayName(): string {
    return Craft::t('contentfield', 'Content field utilities');
  }


  // Private methods
  // ---------------

  /**
   * @param View $view
   * @return array
   */
  private static function getCraftIcons(View $view) {
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
  private static function getMaterialIcons(View $view) {
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

  /**
   * @param array $sources
   * @return array
   */
  private static function getSources($sources) {
    $result = [];
    foreach ($sources as $source) {
      if (
        array_key_exists('key', $source) &&
        array_key_exists('label', $source) &&
        $source['key'] != '*'
      ) {
        $result[] = $source;
      }
    }

    return $result;
  }

  /**
   * @return array
   */
  private static function getSourceTypes() {
    return [
      'Asset sources'       => self::getSources(Asset::sources()),
      'Category sources'    => self::getSources(Category::sources()),
      'Entry sources'       => self::getSources(Entry::sources()),
      'Globals set sources' => self::getSources(GlobalSet::sources()),
      'Tag sources'         => self::getSources(Tag::sources()),
      'User sources'        => self::getSources(User::sources()),
    ];
  }

  /**
   * @return array
   */
  private static function getTabs() {
    return [
      'icons' => [
        'label' => 'Icons',
        'url'   => '/admin/utilities/tcf-utilities?tab=icons',
      ],
      'sources' => [
        'label' => 'Sources',
        'url'   => '/admin/utilities/tcf-utilities?tab=sources',
      ]
    ];
  }
}
