<?php

namespace contentfield\services\loaders;

use craft\helpers\FileHelper;
use Symfony\Component\Yaml\Yaml;

use contentfield\models\schemas\TemplateSchema;

/**
 * Class TemplateLoader
 *
 * A schema loader that fetches schemas from template files.
 */
class TemplateLoader extends AbstractLoader
{
  /**
   * @var string
   */
  private $basePath;

  /**
   * @var array
   */
  private $templates;

  /**
   * Prefix for the schema names loaded by this loader.
   */
  const NAME_PREFIX = 'template:';

  /**
   * Unified path separator.
   */
  const SEPARATOR = '/';


  /**
   * TemplateLoader constructor.
   * @throws \yii\base\Exception
   */
  public function __construct() {
    $this->basePath = FileHelper::normalizePath(
      \Craft::$app->getPath()->getSiteTemplatesPath(),
      self::SEPARATOR
    );
  }

  /**
   * @inheritdoc
   */
  public function findNames($pattern) {
    $templates = $this->getAllTemplates();
    $result    = array();

    foreach ($templates as $template) {
      if (preg_match($pattern, $template['name'])) {
        $result[] = $template['name'];
      }
    }

    return $result;
  }

  /**
   * Returns a flat list of all available templates.
   *
   * @return array
   */
  private function getAllTemplates() {
    if (isset($this->templates)) {
      return $this->templates;
    }

    $generalConfig = \Craft::$app->getConfig()->getGeneral();
    $extensions    = $generalConfig->defaultTemplateExtensions;
    $basePath      = $this->getBasePath();
    $result        = array();

    $iterator = new \RecursiveIteratorIterator(
      new \RecursiveDirectoryIterator($this->basePath)
    );

    /** @var \SplFileInfo $file */
    foreach ($iterator as $file) {
      if (
        !$file->isFile() ||
        !in_array($file->getExtension(), $extensions)
      ) {
        continue;
      }

      $fullPath = FileHelper::normalizePath($file->getRealPath(), self::SEPARATOR);
      if (substr($fullPath, 0, strlen($basePath)) !== $basePath) {
        continue;
      }

      $name = substr($fullPath, strlen($basePath) + 1);
      $path = dirname($name);
      $result[] = array(
        'name' => $name,
        'path' => $path === '.' ? '' : $path,
      );
    }

    $this->templates = $result;
    return $result;
  }

  /**
   * A helper function that returns the list of all templates
   * in a format used by the settings page of the field.
   *
   * @return array
   */
  public function getAllTemplateAsList() {
    $templates = $this->getAllTemplates();

    usort($templates, function($a, $b) {
      return $a['path'] === $b['path']
        ? strcasecmp($a['name'], $b['name'])
        : strcasecmp($a['path'], $b['path']);
    });

    $currentPath = null;
    $result = [];
    foreach ($templates as $template) {
      $path = empty($template['path']) ? '' : $template['path'] . self::SEPARATOR;
      if ($path !== $currentPath) {
        $currentPath = $path;
        $result[] = $path . '*';
      }

      $result[] = $template['name'];
    }

    return array_map(function($name) {
      return array(
        'label' => $name,
        'value' => $name,
      );
    }, $result);
  }

  /**
   * @return string
   */
  public function getBasePath() {
    return $this->basePath;
  }

  /**
   * Return the real path of the given schema name.
   *
   * @param string $name
   * @return null|string
   * @throws \Exception
   */
  public function getTemplatePath($name) {
    $realPath = $this->basePath . DIRECTORY_SEPARATOR . FileHelper::normalizePath($name);
    if (!file_exists($realPath) || !is_readable($realPath)) {
      throw new \Exception('The template "' . $name . '" does not exist.');
    }

    return $realPath;
  }

  /**
   * @inheritdoc
   */
  public function load($name) {
    $path     = $this->getTemplatePath($name);
    $contents = file_get_contents($path);

    if (!preg_match('/^---+/m', $contents, $match, PREG_OFFSET_CAPTURE)) {
      throw new \Exception('The template "' . $name . '" does not contain a yaml preamble.');
    }

    $data = Yaml::parse(substr($contents, 0, $match[0][1]));
    return new TemplateSchema($data + array(
      'path'      => $path,
      'qualifier' => self::NAME_PREFIX . $name,
      'template'  => $name
    ));
  }

  /**
   * @inheritdoc
   */
  public function normalizeName($name) {
    return FileHelper::normalizePath($name, self::SEPARATOR);
  }
}
