<?php

namespace lenz\contentfield\utilities;

use Craft;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use craft\elements\GlobalSet;
use craft\elements\Tag;
use craft\elements\User;

/**
 * Class SourcesUtility
 */
class SourcesPage extends AbstractPage
{
  /**
   * @inheritDoc
   */
  public function contentHtml() {
    $view = Craft::$app->getView();

    return $view->renderTemplate('contentfield/_utility-sources', [
      'sourceTypes' => $this->getSourceTypes(),
    ]);
  }

  /**
   * @inheritDoc
   */
  public function getHandle() {
    return 'sources';
  }

  /**
   * @inheritDoc
   */
  public function getLabel() {
    return 'Sources';
  }


  // Private methods
  // ---------------

  /**
   * @param array $sources
   * @return array
   */
  private function getSources($sources) {
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
  private function getSourceTypes() {
    return [
      'Asset sources'       => $this->getSources(Asset::sources()),
      'Category sources'    => $this->getSources(Category::sources()),
      'Entry sources'       => $this->getSources(Entry::sources()),
      'Globals set sources' => $this->getSources(GlobalSet::sources()),
      'Tag sources'         => $this->getSources(Tag::sources()),
      'User sources'        => $this->getSources(User::sources()),
    ];
  }
}
