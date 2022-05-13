<?php

namespace lenz\contentfield\utilities;

use Craft;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use craft\elements\GlobalSet;
use craft\elements\Tag;
use craft\elements\User;
use craft\models\Volume;

/**
 * Class SourcesUtility
 */
class SourcesPage extends AbstractPage
{
  /**
   * @inheritDoc
   */
  public function contentHtml() : string {
    $view = Craft::$app->getView();

    return $view->renderTemplate('contentfield/_utility-sources', [
      'sourceTypes' => $this->getSourceTypes(),
    ]);
  }

  /**
   * @inheritDoc
   */
  public function getHandle() : string {
    return 'sources';
  }

  /**
   * @inheritDoc
   */
  public function getIcon(): string {
    return 'category';
  }

  /**
   * @inheritDoc
   */
  public function getLabel() : string {
    return 'Sources';
  }


  // Private methods
  // ---------------

  /**
   * @param array $sources
   * @return array
   */
  private function getSources(array $sources): array {
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
   * @param string $context
   * @return array
   */
  private function getSourceTypes(string $context = 'settings'): array {
    return [
      'Asset sources'       => $this->getSources(Asset::sources($context)),
      'Category sources'    => $this->getSources(Category::sources($context)),
      'Entry sources'       => $this->getSources(Entry::sources($context)),
      'Globals set sources' => $this->getSources(GlobalSet::sources($context)),
      'Tag sources'         => $this->getSources(Tag::sources($context)),
      'User sources'        => $this->getSources(User::sources($context)),
      'Volumes'             => $this->getVolumes(),
    ];
  }

  /**
   * @return array
   */
  private function getVolumes(): array {
    return array_map(function(Volume $volume) {
      return [
        'key' => 'volume:' . $volume->uid,
        'label' => $volume->name
      ];
    }, Craft::$app->volumes->getAllVolumes());
  }
}
