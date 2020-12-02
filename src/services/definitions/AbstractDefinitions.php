<?php

namespace lenz\contentfield\services\definitions;

use Craft;
use Exception;
use RecursiveCallbackFilterIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Yaml\Yaml;

/**
 * Class AbstractDefinitions
 */
abstract class AbstractDefinitions
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
   * Return the definition for the given name.
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

  /**
   * Test whether the definition with the given name exists.
   *
   * @param string $name
   * @return bool
   */
  public function hasDefinition($name) {
    if (!isset($this->definitions)) {
      $this->loadDefinitions();
    }

    return isset($this->definitions[$name]);
  }


  // Protected methods
  // -----------------

  /**
   * Return the cache key.
   *
   * @return string
   */
  protected function getCacheKey() {
    return static::class;
  }

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
      $fileInfos = new RecursiveCallbackFilterIterator(
        new RecursiveDirectoryIterator($path),
        function (SplFileInfo $current) {
          $fileName = $current->getFilename();
          return substr($fileName, 0, 1) != '.' && (
            $current->isDir() ||
            substr($fileName, -4) == '.yml' ||
            substr($fileName, -5) == '.yaml'
          );
        }
      );

      /** @var SplFileInfo $fileInfo */
      foreach (new RecursiveIteratorIterator($fileInfos) as $fileInfo) {
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
   * @param string $type
   * @return boolean
   */
  abstract protected function isNativeType($type);

  /**
   * @return bool
   */
  protected function isTypeRequired() {
    return true;
  }

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
      $definitions = array_merge(
        $definitions,
        static::transformDefinitions(
          Yaml::parseFile($source['pathname'])
        )
      );
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
      if (!$this->isTypeRequired()) {
        return $config;
      }

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

    return empty($config)
      ? $parent
      : $this->mergeDefinitions($config, $parent);
  }


  // Static methods
  // --------------

  /**
   * @param array $definitions
   * @return array
   */
  static public function transformDefinitions(array $definitions) {
    return $definitions;
  }
}
