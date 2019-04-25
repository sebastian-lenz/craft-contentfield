<?php

namespace lenz\contentfield\utilities;

use craft\web\twig\TemplateLoaderException;

/**
 * Class TemplateLoader
 * @package contentfield\twig
 */
class TemplateLoader extends \craft\web\twig\TemplateLoader
{
  /**
   * @inheritdoc
   */
  public function getSourceContext($name) {
    $template = $this->getCacheKey($name);
    if (!is_readable($template)) {
      throw new TemplateLoaderException($name, \Craft::t('app', 'Tried to read the template at {path}, but could not. Check the permissions.', ['path' => $template]));
    }

    $contents = file_get_contents($template);
    if (preg_match('/^---+/m', $contents, $match, PREG_OFFSET_CAPTURE)) {
      $contents = substr($contents, $match[0][1] + strlen($match[0][0]));
    }

    return new \Twig_Source($contents, $name, $template);
  }
}
