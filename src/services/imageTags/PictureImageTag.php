<?php

namespace lenz\contentfield\services\imageTags;

use craft\helpers\Html;
use lenz\contentfield\services\imageTags\scopes\AbstractScope;
use lenz\contentfield\services\imageTags\sources\SourceGroup;

/**
 * Class PictureImageTag
 *
 * Renders a basic <picture /> tag.
 */
class PictureImageTag extends ImageImageTag
{
  /**
   * @inheritDoc
   */
  public function render(): string {
    $children = $this->getSourceTags();
    $children[] = parent::render();

    return Html::tag('picture', implode('', $children));
  }


  // Protected methods
  // -----------------

  /**
   * @return string[]
   */
  protected function getSourceTags(): array {
    $groups = $this->getSourceGroups()
      ->getGroups();

    return array_map(function(SourceGroup $group) {
      $attributes = array_merge($group->attributes, [
        'srcset' => '{srcset}',
      ]);

      return Html::tag('source', '',
        AbstractScope::expandAttributes($group->getVariables(), $attributes)
      );
    }, $groups);
  }
}
