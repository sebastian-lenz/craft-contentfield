<?php

namespace lenz\contentfield\services\imageTags\nodes;

use Exception;
use lenz\contentfield\services\imageTags\scopes\ScopeInterface;

/**
 * Class NoscriptNode
 */
class NoscriptNode extends TagNode
{
  /**
   * NoscriptNode constructor.
   *
   * @param ScopeInterface $parent
   * @throws Exception
   */
  public function __construct(ScopeInterface $parent) {
    parent::__construct($parent, [
      'tagName' => 'noscript',
      'children' => [
        'img'    => [
          'tagName' => 'img',
          'attributes' => [
            'alt'    => '{title}',
            'src'    => '{src}',
            'height' => '{height}',
            'width'  => '{width}',
          ]
        ],
      ]
    ]);
  }
}
