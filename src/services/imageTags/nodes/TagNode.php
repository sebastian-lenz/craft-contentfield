<?php

namespace lenz\contentfield\services\imageTags\nodes;

use craft\helpers\Html;
use Exception;
use lenz\contentfield\services\imageTags\scopes\AbstractScope;
use lenz\contentfield\services\imageTags\scopes\ScopeInterface;
use lenz\contentfield\services\imageTags\sources\SourceGroup;

/**
 * Class TagNode
 */
class TagNode extends AbstractScope implements NodeInterface
{
  /**
   * @var array
   */
  public array $attributes = [];

  /**
   * @var mixed
   */
  public mixed $repeat = null;

  /**
   * @var string
   */
  public string $tagName = 'div';

  /**
   * @var NodeInterface[]
   */
  private array $_children = [];


  /**
   * @inheritDoc
   */
  public function render(ScopeInterface $scope = null): string {
    if (empty($this->repeat)) {
      return Html::tag(
        $this->tagName,
        $this->getTagChildren($scope),
        $this->getTagAttributes($scope)
      );
    }

    $tags = array_map(function(SourceGroup $group) {
      $attributes = AbstractScope::expandAttributes(
        $group->getVariables(),
        array_merge(
          $this->attributes,
          $group->attributes
        )
      );

      return Html::tag(
        $this->tagName,
        $this->getTagChildren($group),
        $attributes
      );
    }, $this->getSourceGroups()->getGroups());

    return implode('', $tags);
  }

  /**
   * @param array|string $content
   * @throws Exception
   * @noinspection PhpUnused
   */
  public function setChildren(array|string $content) {
    $this->_children = [];

    if (is_array($content)) {
      foreach ($content as $key => $value) {
        $this->addChild($value, $key);
      }
    } else {
      $this->addChild($content);
    }
  }


  // Private methods
  // ---------------

  /**
   * @param mixed $value
   * @param int|string|null $key
   * @throws Exception
   */
  private function addChild(mixed $value, int|string $key = null) {
    if ($key == 'noscript' && !is_array($value)) {
      $this->_children[] = new NoscriptNode($this);
    } elseif (is_array($value)) {
      if (is_string($key) && !array_key_exists('tagName', $value)) {
        $value['tagName'] = $key;
      }

      $this->_children[] = new TagNode($this, $value);
    } else {
      $this->_children[] = new TextNode((string)$value);
    }
  }

  /**
   * @param ScopeInterface|null $scope
   * @return array
   */
  private function getTagAttributes(ScopeInterface $scope = null): array {
    $scope = is_null($scope)
      ? $this
      : $scope;

    return AbstractScope::expandAttributes(
      $scope->getSources()->getVariables(),
      $this->attributes
    );
  }

  /**
   * @param ScopeInterface|null $scope
   * @return string
   */
  private function getTagChildren(ScopeInterface $scope = null): string {
    return implode('', array_map(
      fn(NodeInterface $node) => $node->render($scope),
      $this->_children
    ));
  }
}
