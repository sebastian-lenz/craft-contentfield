<?php

namespace contentfield\services;

use Symfony\Component\Yaml\Yaml;

/**
 * Class AbstractDefinitionService
 */
abstract class AbstractDefinitionService
{
  /**
   * @var array
   */
  private $definitions;

  /**
   * @var string[]
   */
  const DEFINITION_ATTRIBUTES = ['extends', 'type'];

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

  /**
   * @return string
   */
  abstract protected function getDefinitionName();

  /**
   * @return string[]
   */
  protected function getDefinitionSources() {
    $sources = array();
    $basePath = \Craft::$app->getConfig()->configDir . DIRECTORY_SEPARATOR . self::DEFINITION_BASE_PATH;
    $name = $this->getDefinitionName();

    $file = $basePath . DIRECTORY_SEPARATOR . $name . self::DEFINITION_EXTENSION;
    if (file_exists($file) && is_readable($file)) {
      $sources['*'] = $file;
    }

    $path = $basePath . DIRECTORY_SEPARATOR . $name;
    if (file_exists($path) && is_dir($path)) {
      $paths = new \RecursiveDirectoryIterator($path);
      $files = new \RecursiveIteratorIterator($paths);
      $filteredFiles = new \RegexIterator($files, '/^.+\.yml$/i', \RecursiveRegexIterator::GET_MATCH);

      /** @var \SplFileInfo $fileInfo */
      foreach ($filteredFiles as $fileInfo) {
        $key = $fileInfo->getBasename('.yml');
        $sources[$key] = $fileInfo->getPathname();
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

    $definitions = array();
    $sources = $this->getDefinitionSources();

    foreach ($sources as $key => $source) {
      try {
        $definitions = array_merge(
          $definitions,
          Yaml::parseFile($source)
        );
      } catch (\Throwable $error) {
        \Craft::error($error->getMessage());
      }
    }

    $this->definitions = $definitions;
  }

  /**
   * @param array $config
   * @param array $definition
   * @return array
   */
  protected function mergeDefinitions($config, $definition) {
    return array_merge($definition, $config);
  }

  /**
   * @param array $config
   * @return array
   * @throws \Exception
   */
  protected function resolveDefinition(array $config) {
    $stack = array();

    do {
      $hasChanged = false;
      foreach (self::DEFINITION_ATTRIBUTES as $attribute) {
        if (!isset($config[$attribute])) {
          continue;
        }

        $value = $config[$attribute];
        if (
          !is_string($value) ||
          !$this->hasDefinition($value) ||
          $this->isNativeType($value)
        ) {
          continue;
        }

        if (in_array($value, $stack)) {
          throw new \Exception('Found recursive definition inheritance.');
        }

        $stack[] = $value;
        $hasChanged = true;

        unset($config[$attribute]);
        $config = $this->mergeDefinitions($config, $this->getDefinition($value));
      }
    } while ($hasChanged);

    return $config;
  }
}
