<?php

namespace lenz\contentfield\services\definitions;

use Craft;
use Exception;
use lenz\contentfield\Config;
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
  protected array $definitions;

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
  public function getDefinition(string $name): array {
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
  public function hasDefinition(string $name): bool {
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
  protected function getCacheKey(): string {
    return static::class;
  }

  /**
   * @return string
   */
  abstract protected function getDefinitionName(): string;

  /**
   * @return array
   */
  protected function getDefinitionSources(): array {
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
      $fileInfos = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path)
      );

      /** @var SplFileInfo $fileInfo */
      foreach ($fileInfos as $fileInfo) {
        $fileName = $fileInfo->getFilename();
        $extension = $fileInfo->getExtension();
        if (
          $fileInfo->isDir() ||
          str_starts_with($fileName, '.') ||
          !in_array($extension, ['yaml', 'yml'])
        ) {
          continue;
        }

        $key = implode('/', array_filter([
          substr($fileInfo->getPath(), strlen($path) + 1),
          $fileInfo->getBasename(".$extension")
        ]));

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
  abstract protected function isNativeType(string $type): bool;

  /**
   * @return bool
   */
  protected function isTypeRequired(): bool {
    return true;
  }

  /**
   * Loads all blueprints.
   *
   * @return void
   */
  protected function loadDefinitions(): void {
    if (isset($this->definitions)) {
      return;
    }

    $cache     = Craft::$app->getCache();
    $cacheKey  = $this->getCacheKey();
    $cacheData = $cache->get($cacheKey);

    // In production mode we just return the data
    if (
      Config::getEnvironment() == 'production' &&
      is_array($cacheData) &&
      array_key_exists('data', $cacheData)
    ) {
      $this->definitions = $cacheData['data'];
      return;
    }

    // Otherwise, create a hash of all files and check for updates
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

    // Finally, read all the definitions
    $definitions = [];
    foreach ($sources as $source) {
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
  protected function mergeDefinitions(array $config, array $parent): array {
    return array_merge($parent, $config);
  }

  /**
   * @param array $config
   * @param array $stack
   * @return array
   * @throws Exception
   */
  protected function resolveDefinition(array $config, array $stack = []): array {
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

    // If we already have that type in out stack, bail out
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
  static public function transformDefinitions(array $definitions): array {
    return $definitions;
  }
}
