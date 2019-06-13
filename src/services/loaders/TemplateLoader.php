<?php

namespace lenz\contentfield\services\loaders;

use Craft;
use craft\helpers\FileHelper;
use craft\helpers\Json;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Yaml\Yaml;

use lenz\contentfield\models\schemas\TemplateSchema;

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
  private $_basePath;

  /**
   * @var array
   */
  private $_templates;

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
    $this->_basePath = FileHelper::normalizePath(
      Craft::$app->getPath()->getSiteTemplatesPath(),
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
   * @inheritDoc
   */
  public function getAllSchemas() {
    $schemas = [];

    foreach ($this->getAllTemplates() as $template) {
      try {
        $schemas[] = $this->load($template['name']);
      } catch (Exception $error) {
        // Just skip errors, there may be templates without a yaml header
      }
    }

    return $schemas;
  }

  /**
   * @return string
   */
  public function getBasePath() {
    return $this->_basePath;
  }

  /**
   * Return the real path of the given schema name.
   *
   * @param string $name
   * @return null|string
   * @throws Exception
   */
  public function getTemplatePath($name) {
    $realPath = $this->_basePath . DIRECTORY_SEPARATOR . FileHelper::normalizePath($name);
    if (!file_exists($realPath) || !is_readable($realPath)) {
      throw new Exception('The template "' . $name . '" does not exist.');
    }

    return $realPath;
  }

  /**
   * @inheritdoc
   */
  public function load($name) {
    $path = $this->getTemplatePath($name);
    $data = $this->loadFromCache($name, $path);
    if (is_null($data)) {
      $data = $this->loadFromSource($name, $path);
    }

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


  // Private methods
  // ---------------

  /**
   * Returns a flat list of all available templates.
   *
   * @return array
   */
  private function getAllTemplates() {
    if (!isset($this->_templates)) {
      if (CRAFT_ENVIRONMENT == 'production') {
        $key = static::class . '::getAllTemplates';
        $this->_templates = Craft::$app->getCache()->getOrSet($key, function() {
          return $this->getAllTemplatesFromDisk();
        });
      } else {
        $this->_templates = $this->getAllTemplatesFromDisk();
      }
    }

    return $this->_templates;
  }

  /**
   * @return array
   */
  private function getAllTemplatesFromDisk() {
    $generalConfig = Craft::$app->getConfig()->getGeneral();
    $extensions    = $generalConfig->defaultTemplateExtensions;
    $basePath      = $this->getBasePath();
    $result        = array();

    $iterator = new RecursiveIteratorIterator(
      new RecursiveDirectoryIterator($this->_basePath)
    );

    /** @var SplFileInfo $file */
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

    return $result;
  }

  /**
   * @param string $name
   * @return string
   */
  private function getCacheKey($name) {
    return static::class . '::getCacheKey(' . $name . ')';
  }

  /**
   * @param string $name
   * @param string $path
   * @return array|null
   */
  private function loadFromCache($name, $path) {
    $data = Craft::$app->getCache()->get($this->getCacheKey($name));
    if ($data === false) {
      return null;
    }

    try {
      $data = Json::decode($data);

      // If we are not in production mode, check filemtime
      if (CRAFT_ENVIRONMENT != 'production') {
        if ($data['filemtime'] != filemtime($path)) {
          return null;
        }
      }

      // Return the cached data
      if (array_key_exists('data', $data)) {
        return $data['data'];
      }
    } catch (Exception $error) { }

    return null;
  }

  /**
   * @param string $name
   * @param string $path
   * @return array
   * @throws Exception
   */
  private function loadFromSource($name, $path) {
    $contents = file_get_contents($path);

    if (!preg_match('/^---+/m', $contents, $match, PREG_OFFSET_CAPTURE)) {
      throw new Exception('The template "' . $name . '" does not contain a yaml preamble.');
    }

    $data = Yaml::parse(substr($contents, 0, $match[0][1]));
    Craft::$app->getCache()->set($this->getCacheKey($name), Json::encode([
      'filemtime' => filemtime($path),
      'data'      => $data,
    ]));

    return $data;
  }
}
