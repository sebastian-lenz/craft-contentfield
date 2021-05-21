<?php

namespace lenz\contentfield\twig\nodeVisitors;

use Exception;
use lenz\contentfield\twig\nodes\DisplayNode;
use lenz\contentfield\twig\nodes\SiblingsNode;
use Throwable;
use Twig\Environment;
use Twig\Node\ModuleNode;
use Twig\Node\Node;
use Twig\NodeVisitor\AbstractNodeVisitor;

/**
 * Class DisplayNodeVisitor
 */
class DisplayNodeVisitor extends AbstractNodeVisitor
{
  /**
   * @var DisplayNodeVisitorContext|null
   */
  private $_context = null;


  /**
   * @inheritDoc
   * @throws Throwable
   */
  protected function doEnterNode(Node $node, Environment $env): Node {
    if ($node instanceof ModuleNode) {
      $this->_context = new DisplayNodeVisitorContext($node, $this->_context);
    } elseif ($node instanceof DisplayNode) {
      $this->attachDisplay($node, $env);
    } else if ($node instanceof SiblingsNode) {
      $this->attachSibling();
    }

    return $node;
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  protected function doLeaveNode(Node $node, Environment $env) {
    if ($node instanceof ModuleNode) {
      if (
        is_null($this->_context) ||
        $this->_context->getModule() !== $node
      ) {
        throw new Exception('Invalid twig module hierarchy.');
      }

      $this->_context = $this->_context->getParent();
    }

    return $node;
  }

  /**
   * @inheritDoc
   */
  public function getPriority(): int {
    return 0;
  }


  // Protected methods
  // -----------------

  /**
   * @param DisplayNode $node
   * @param Environment $env
   * @throws Throwable
   */
  protected function attachDisplay(DisplayNode $node, Environment $env) {
    $context = $this->_context;
    if (is_null($context)) {
      throw new Exception('Cannot compile display tag, context is missing.');
    }

    foreach ($node->getInlineSchemaCandidates() as $candidate) {
      $callback = $context->tryInline($candidate, $env);

      if (!is_null($callback)) {
        $node->setInlinedSchema($candidate->qualifier, $callback);
      }
    }

    if ($node->usesIndexDisplay()) {
      $context->requireIndex();
    }
  }

  /**
   * @throws Exception
   */
  protected function attachSibling() {
    $context = $this->_context;
    if (is_null($context)) {
      throw new Exception('Cannot compile sibling tag, context is missing.');
    }

    $context->requireIndex();
  }
}
