<?php

namespace lenz\contentfield\utilities;

use Craft;
use craft\base\Utility;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use craft\elements\GlobalSet;
use craft\elements\Tag;
use craft\elements\User;
use Exception;

/**
 * Class SourcesUtility
 */
class SourcesUtility extends Utility
{
  /**
   * @inheritdoc
   */
  public static function contentHtml(): string {
    $view = Craft::$app->getView();

    try {
      return $view->renderTemplate('contentfield/_sources', array(
        'sourceTypes' => [
          'Asset sources'       => self::getFilteredSources(Asset::sources()),
          'Category sources'    => self::getFilteredSources(Category::sources()),
          'Entry sources'       => self::getFilteredSources(Entry::sources()),
          'Globals set sources' => self::getFilteredSources(GlobalSet::sources()),
          'Tag sources'         => self::getFilteredSources(Tag::sources()),
          'User sources'        => self::getFilteredSources(User::sources()),
        ]
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
    return 'tcf-sources';
  }

  /**
   * @inheritdoc
   */
  public static function displayName(): string {
    return Craft::t('contentfield', 'Sources');
  }


  // Private methods
  // ---------------

  /**
   * @param array $sources
   * @return array
   */
  private static function getFilteredSources($sources) {
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
}
