<?php

namespace lenz\contentfield\services;

use Craft;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use SplFileInfo;
use Symfony\Component\Yaml\Yaml;
use Throwable;

/**
 * Class AbstractDefinitionService
 */
abstract class AbstractDefinitionService
{
  /**
   * @var array
   */
  protected $definitions;

  /**
   * @var string
   */
  const DEFINITION_TYPE = 'type';

  /**
   * @var string
   */
  const DEFINITION_BASE_PATH = 'content';

  /**
   * @var string
   */
  const DEFINITION_EXTENSION = '.yml';


  /**
   * Return the blueprint field definition for the given name.
   *
   * @param string $name
   * @return array
   */
  public function getDefinition($name) {
    if (!isset($this->definitions)) {
      $this->loadDefinitions();
    }

    if (!isset($this->definitions[$name])) {
      return [];
    }

    $definition = $this->definitions[$name];
    return is_array($definition) ? $definition : [];
  }


  // Protected methods
  // -----------------

  /**
   * Return the cache key.
   *
   * @return string
   */
  abstract protected function getCacheKey();

  /**
   * @return string
   */
  abstract protected function getDefinitionName();

  /**
   * @return array
   */
  protected function getDefinitionSources() {
    $sources = [];
    $name    = $this->getDefinitionName();
    $path    = implode(DIRECTORY_SEPARATOR, [
      Craft::$app->getConfig()->configDir,
      self::DEFINITION_BASE_PATH,
      $name
    ]);

    $file = $path . self::DEFINITION_EXTENSION;
    if (file_exists($file) && is_readable($file)) {
      $sources['*'] = [
        'pathname' => $file,
        'mtime'    => filemtime($file),
      ];
    } elseif (file_exists($path) && is_dir($path)) {
      $paths = new RecursiveDirectoryIterator($path);
      $files = new RecursiveIteratorIterator($paths);
      $filteredFiles = new RegexIterator($files, '/^.+\.yml$/i', RecursiveRegexIterator::GET_MATCH);

      /** @var SplFileInfo $fileInfo */
      foreach ($filteredFiles as $fileInfo) {
        $key = $fileInfo->getBasename('.yml');
        $sources[$key] = [
          'pathname' => $fileInfo->getPathname(),
          'mtime'    => $fileInfo->getMTime(),
        ];
      }
    }

    return $sources;
  }

  /**
   * Test whether the blueprint with the given name exists.
   *
   * @param string $name
   * @return bool
   */
  protected function hasDefinition($name) {
    if (!isset($this->definitions)) {
      $this->loadDefinitions();
    }

    return isset($this->definitions[$name]);
  }

  /**
   * @param string $type
   * @return boolean
   */
  abstract protected function isNativeType($type);

  /**
   * Loads all blueprints.
   *
   * @return void
   */
  protected function loadDefinitions() {
    if (isset($this->definitions)) {
      return;
    }

    $cache     = Craft::$app->getCache();
    $cacheKey  = $this->getCacheKey();
    $cacheData = $cache->get($cacheKey);

    // In production mode we just return the data
    if (
      CRAFT_ENVIRONMENT == 'production' &&
      is_array($cacheData) &&
      array_key_exists('data', $cacheData)
    ) {
      $this->definitions = $cacheData['data'];
      return;
    }

    // Otherwise create a hash of all files and check for updates
    $sources = $this->getDefinitionSources();
    $hash = md5(implode(';', array_map(function($source) {
      return implode(',', array_values($source));
    }, $sources)));

    if (
      is_array($cacheData) &&
      array_key_exists('data', $cacheData) &&
      $cacheData['hash'] == $hash
    ) {
      $this->definitions = $cacheData['data'];
      return;
    }

    // Finally read all the definitions
    $definitions = array();
    foreach ($sources as $key => $source) {
      try {
        $definitions = array_merge(
          $definitions,
          Yaml::parseFile($source['pathname'])
        );
      } catch (Throwable $error) {
        Craft::error($error->getMessage());
      }
    }

    $this->definitions = $definitions;
    $cache->set($cacheKey, array(
      'hash' => $hash,
      'data' => $definitions
    ));
  }

  /**
   * @param array $config
   * @param array $parent
   * @return array
   */
  protected function mergeDefinitions(array $config, array $parent) {
    return array_merge($parent, $config);
  }

  /**
   * @param array $config
   * @param array $stack
   * @return array
   * @throws Exception
   */
  protected function resolveDefinition(array $config, array $stack = []) {
    if (
      !array_key_exists(static::DEFINITION_TYPE, $config) ||
      !is_string($config[static::DEFINITION_TYPE])
    ) {
      throw new Exception(sprintf(
        'A definition must contain a `%s` type attribute.',
        static::DEFINITION_TYPE
      ));
    }

    // If the definition is of a native type or we don't know about
    // it we are done
    $type = $config[static::DEFINITION_TYPE];
    if (
      $this->isNativeType($type) ||
      !$this->hasDefinition($type)
    ) {
      return $config;
    }

    // If we have already have that type in out stack, bail out
    if (in_array($type, $stack)) {
      throw new Exception('Recursive definition inheritance.');
    }

    unset($config[static::DEFINITION_TYPE]);
    $stack[] = $type;
    $parent  = $this->resolveDefinition($this->getDefinition($type), $stack);

    return $this->mergeDefinitions($config, $parent);
  }
}
