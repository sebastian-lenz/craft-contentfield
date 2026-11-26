<?php

namespace lenz\contentfield\twig\nodeVisitors;

use Twig\Node\Expression\MacroReferenceExpression;
use Twig\Node\Expression\Variable\MacroVariable;
use Twig\Node\ImportNode;
use Twig\Node\MacroNode;
use Twig\Node\MacrosNode;
use Twig\Node\ModuleNode;
use Twig\Node\Node;
use Twig\Node\Nodes;

/**
 * Gives the macros of an inlined template unique names.
 *
 * Inlining merges the macros of all inlined templates into the host template.
 * As macros are looked up by name, macros sharing a name (e.g. `results`
 * declared by two element templates) would overwrite each other and calls
 * like `_self.results()` would invoke the macro of another template. This
 * helper renames the macros of a module and all references the module makes
 * to its own macros (`_self.name()`, `import _self as x`, `from _self import`).
 */
class InlineMacroScope
{
  /**
   * Prefix used by Twig < 3.29 for macro method names.
   */
  const LEGACY_PREFIX = 'macro_';


  /**
   * Renames the macros of the given module using the given suffix.
   *
   * @param ModuleNode $module
   * @param string $suffix
   * @return void
   */
  static public function apply(ModuleNode $module, string $suffix): void {
    $renames = [];
    $macros = [];
    foreach ($module->getNode('macros') as $key => $macro) {
      if (!($macro instanceof MacroNode)) {
        $macros[$key] = $macro;
        continue;
      }

      $name = $macro->getAttribute('name');
      $legacy = str_starts_with($name, self::LEGACY_PREFIX);
      $bare = $legacy ? substr($name, strlen(self::LEGACY_PREFIX)) : $name;
      $renamed = $bare . '__' . $suffix;

      $renames[$bare] = $renamed;
      $macro->setAttribute('name', ($legacy ? self::LEGACY_PREFIX : '') . $renamed);
      $macros[$renamed] = $macro;
    }

    if (empty($renames)) {
      return;
    }

    // The macros are merged by their keys when inlining, re-key them
    $module->setNode('macros', class_exists(MacrosNode::class)
      ? new MacrosNode($macros)
      : new Nodes($macros));

    // Find all aliases pointing to the module itself
    $aliases = ['_self' => true];
    $variables = [];
    self::walk($module, function(Node $node) use (&$aliases, &$variables) {
      if (!($node instanceof ImportNode) || !self::isSelfReference($node->getNode('expr'))) {
        return;
      }

      $var = $node->getNode('var');
      if (!($var instanceof MacroVariable) && $var->hasNode('var')) {
        $var = $var->getNode('var');
      }

      $variables[spl_object_id($var)] = true;
      if ($var->hasAttribute('name') && is_string($var->getAttribute('name'))) {
        $aliases[$var->getAttribute('name')] = true;
      }
    });

    // Rename all references to the own macros
    self::walk($module, function(Node $node) use ($aliases, $renames, $variables) {
      if (
        !($node instanceof MacroReferenceExpression) ||
        !$node->hasAttribute('name') ||
        !is_string($node->getAttribute('name')) ||
        !$node->hasNode('template')
      ) {
        return;
      }

      $template = $node->getNode('template');
      $name = $template->hasAttribute('name') ? $template->getAttribute('name') : null;
      if (
        !isset($variables[spl_object_id($template)]) &&
        !(is_string($name) && isset($aliases[$name]))
      ) {
        return;
      }

      $macro = $node->getAttribute('name');
      $legacy = str_starts_with($macro, self::LEGACY_PREFIX) && !isset($renames[$macro]);
      $bare = $legacy ? substr($macro, strlen(self::LEGACY_PREFIX)) : $macro;

      if (isset($renames[$bare])) {
        $node->setAttribute('name', ($legacy ? self::LEGACY_PREFIX : '') . $renames[$bare]);
      }
    });
  }


  // Private methods
  // ---------------

  /**
   * @param Node $node
   * @return bool
   */
  static private function isSelfReference(Node $node): bool {
    return (
      $node->hasAttribute('name') &&
      $node->getAttribute('name') === '_self'
    );
  }

  /**
   * @param Node $node
   * @param callable $callback
   * @return void
   */
  static private function walk(Node $node, callable $callback): void {
    $callback($node);
    foreach ($node as $child) {
      self::walk($child, $callback);
    }
  }
}
