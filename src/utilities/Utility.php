<?php

namespace lenz\contentfield\utilities;

use Craft;
use craft\base\Utility as UtilityBase;
use Throwable;

/**
 * Class Utility
 */
class Utility extends UtilityBase
{
  /**
   * @inheritdoc
   */
  public static function contentHtml(): string {
    $tabs          = [];
    $pages         = self::getPages();
    $view          = Craft::$app->getView();
    $currentHandle = Craft::$app->getRequest()->getQueryParam('tab');
    $current       = reset($pages);

    foreach ($pages as $page) {
      $pageHandle = $page->getHandle();
      $tabs[$pageHandle] = $page->getTab();

      if ($pageHandle == $currentHandle) {
        $current = $page;
      }
    }

    try {
      return $view->renderTemplate('contentfield/_utility', [
        'content'     => $current->contentHtml(),
        'selectedTab' => $current->getHandle(),
        'tabs'        => $tabs,
      ]);
    } catch (Throwable $error) {
      return $error->getMessage();
    }
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
   * @return AbstractPage[]
   */
  private static function getPages() {
    return [
      new IconPage(),
      new SourcesPage()
    ];
  }
}
