<?php

namespace lenz\contentfield\services\schemas;

use CallbackFilterIterator;
use Craft;
use craft\helpers\FileHelper;
use Exception;
use lenz\contentfield\Config;
use lenz\contentfield\exceptions\TemplateConfigException;
use lenz\contentfield\exceptions\YamlMissingException;
use lenz\contentfield\models\schemas\AbstractSchema;
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
   * @var string[]
   */
  private array $_basePaths;

  /**
   * @var YamlAwareTemplateLoader
   */
  private YamlAwareTemplateLoader $_loader;

  /**
   * @var array
   */
  private array $_templates;

  /**
   * Prefix for the schema names loaded by this loader.
   */
  const NAME_PREFIX = 'template:';


  /**
   * TemplateLoader constructor.
   * @throws Throwable
   */
  public function __construct() {
    $loader = TemplateSchema::getTwig()->getLoader();
    if (!($loader instanceof YamlAwareTemplateLoader)) {
      throw new Exception('Twig template loader is not patched correctly.');
    }

    $this->_loader = $loader;
  }

  /**
   * @inheritdoc
   */
  public function findNames(string $pattern): array {
    $templates = $this->getAllTemplates();
    $result    = [];

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
  public function getAllSchemas(): array {
    return YamlAwareTemplateLoader::withSiteView(function() {
      $errors  = [];
      $schemas = [];

      foreach ($this->getAllTemplates() as $template) {
        try {
          $schemas[] = $this->load($template['name']);
        } catch (Throwable $error) {
          if (!($error instanceof YamlMissingException)) {
            $errors[$template['name']] = $error;
          }
        }
      }

      return [$schemas, $errors];
    });
  }

  /**
   * @return string[]
   * @throws \yii\base\Exception
   */
  public function getBasePaths(): array {
    if (!isset($this->_basePaths)) {
      $templateRoots = Craft::$app->getView()->getSiteTemplateRoots();
      $basePaths = array_key_exists('', $templateRoots) ? $templateRoots[''] : [];

      array_unshift($basePaths, FileHelper::normalizePath(
        Craft::$app->getPath()->getSiteTemplatesPath(),
        YamlAwareTemplateLoader::SEPARATOR
      ));

      $this->_basePaths = $basePaths;
    }

    return $this->_basePaths;
  }

  /**
   * @inheritdoc
   */
  public function load(string $name): AbstractSchema {
    $name = $this->normalizeName($name);
    $data = $this->_loader->getMetaData($name);

    if (is_null($data['preamble'])) {
      throw new YamlMissingException(sprintf(
        'The template `%s` does not contain a yaml preamble.',
        $name
      ));
    }

    try {
      return new TemplateSchema($data['preamble'] + [
        'path'      => $data['path'],
        'qualifier' => self::NAME_PREFIX . $name,
        'template'  => $name
      ]);
    } catch (TemplateConfigException $error) {
      throw $error;
    } catch (Exception $error) {
      throw new TemplateConfigException(
        $data['preamble'],
        sprintf('The template schema `%s` could not be loaded: %s.', $name, $error->getMessage()),
        0,
        $error
      );
    }
  }

  /**
   * @inheritdoc
   */
  public function normalizeName(string $name): string {
    return YamlAwareTemplateLoader::normalizeName($name);
  }


  // Private methods
  // ---------------

  /**
   * @param string $basePath
   * @return CallbackFilterIterator
   */
  private function getTemplateIterator(string $basePath): CallbackFilterIterator {
    $extensions = Craft::$app->getConfig()
      ->getGeneral()
      ->defaultTemplateExtensions;

    return new CallbackFilterIterator(
      new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basePath)),
      fn(SplFileInfo $fileInfo) => $fileInfo->isFile() && in_array($fileInfo->getExtension(), $extensions)
    );
  }

  /**
   * Returns a flat list of all available templates.
   *
   * @return array
   * @throws \yii\base\Exception
   */
  private function getAllTemplates(): array {
    if (!isset($this->_templates)) {
      if (Config::getInstance()->useTemplateIndexCache()) {
        $this->_templates = Craft::$app->getCache()->getOrSet(__METHOD__, function() {
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
   * @throws \yii\base\Exception
   */
  private function getAllTemplatesFromDisk(): array {
    $basePaths = $this->getBasePaths();
    $result = [];

    foreach ($basePaths as $basePath) {
      foreach ($this->getTemplateIterator($basePath) as $file) {
        $fullPath = FileHelper::normalizePath(
          $file->getRealPath(),
          YamlAwareTemplateLoader::SEPARATOR
        );

        if (!str_starts_with($fullPath, $basePath)) {
          continue;
        }

        $name = substr($fullPath, strlen($basePath) + 1);
        $path = dirname($name);
        $result[] = [
          'name' => YamlAwareTemplateLoader::normalizeName($name),
          'path' => $path === '.' ? '' : $path,
        ];
      }
    }

    return $result;
  }
}
