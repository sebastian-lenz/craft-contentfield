<?php

namespace lenz\contentfield\services\loaders;

use Craft;
use craft\helpers\FileHelper;
use Exception;
use lenz\contentfield\exceptions\TemplateConfigException;
use lenz\contentfield\models\schemas\TemplateSchema;
use lenz\contentfield\twig\YamlAwareTemplateLoader;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Throwable;

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
   * @var YamlAwareTemplateLoader
   */
  private $_loader;

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
   * @throws Throwable
   */
  public function __construct() {
    $basePath = FileHelper::normalizePath(
      Craft::$app->getPath()->getSiteTemplatesPath(),
      self::SEPARATOR
    );

    $loader = TemplateSchema::getTwig()->getLoader();
    if (!($loader instanceof YamlAwareTemplateLoader)) {
      throw new Exception('Twig template loader is not patched correctly.');
    }

    $this->_basePath = $basePath;
    $this->_loader   = $loader;
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
   * @throws \yii\base\Exception
   */
  public function getAllSchemas() {
    return YamlAwareTemplateLoader::withSiteView(function() {
      $schemas = [];

      foreach ($this->getAllTemplates() as $template) {
        try {
          $schemas[] = $this->load($template['name']);
        } catch (Throwable $error) {
          // Just skip errors, there may be templates without a yaml header
        }
      }

      return $schemas;
    });
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
    $data = $this->_loader->getMetaData($name);
    if (is_null($data['preamble'])) {
      throw new Exception(sprintf(
        'The template `%s` does not contain a yaml preamble.',
        $name
      ));
    }

    try {
      return new TemplateSchema($data['preamble'] + array(
        'path'      => $data['path'],
        'qualifier' => self::NAME_PREFIX . $name,
        'template'  => $name
      ));
    } catch (Exception $error) {
      if ($error instanceof TemplateConfigException) {
        throw $error;
      } else {
        throw new TemplateConfigException(
          $data['preamble'],
          sprintf('The template schema `%s` could not be loaded: %s.', $name, $error->getMessage()),
          0,
          $error
        );
      }
    }
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
}
