<?php

namespace lenz\contentfield\services\imageTags\nodes;

use lenz\contentfield\services\imageTags\scopes\ScopeInterface;

/**
 * Class TextNode
 */
class TextNode implements NodeInterface
{
  /**
   * @var string
   */
  public $text;


  /**
   * TextNode constructor.
   *
   * @param string $text
   */
  public function __construct(string $text) {
    $this->text = $text;
  }

  /**
   * @inheritDoc
   */
  public function render(ScopeInterface $scope = null) : string {
    return $this->text;
  }
}
