<?php

namespace lenz\contentfield\twig;

use Craft;
use craft\helpers\FileHelper;
use craft\web\twig\Environment;
use craft\web\twig\TemplateLoader;
use craft\web\twig\TemplateLoaderException;
use craft\web\View;
use Exception;
use lenz\contentfield\Config;
use lenz\contentfield\exceptions\YamlException;
use lenz\contentfield\models\schemas\AbstractSchema;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Throwable;
use Twig\Source;

/**
 * Class YamlAwareTemplateLoader
 */
class YamlAwareTemplateLoader extends TemplateLoader
{
  /**
   * @var bool
   */
  private bool $_hasMetaDataChanged = false;

  /**
   * @var array
   */
  private array $_metaData;

  /**
   * Unified path separator.
   */
  const SEPARATOR = '/';


  /**
   * @param string $name
   * @return array
   * @throws Throwable
   */
  public function getMetaData(string $name): array {
    $name = self::normalizeName($name);

    $this->loadCachedMetaData();
    if (!isset($this->_metaData[$name])) {
      $this->_metaData[$name] = $this->loadMetaData($name);
    }

    return $this->_metaData[$name];
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function getSourceContext($name): Source {
    if (is_null($this->view)) {
      throw new Exception('View is required on template loaders.');
    }

    $template = $this->view->resolveTemplate($name, View::TEMPLATE_MODE_SITE);

    if ($template === false || !is_readable($template)) {
      throw new TemplateLoaderException($name,
        Craft::t(
          'app',
          'The template `{name}` at `{path}` could not be read, check file permissions.',
          ['name' => $name, 'path' => $template]
        )
      );
    }

    // Check for yaml header
    $contents = file_get_contents($template);
    if (preg_match('/^---+/m', $contents, $match, PREG_OFFSET_CAPTURE)) {
      $this->saveMetaData($name, $template, substr($contents, 0, $match[0][1]));
      $contents = substr($contents, $match[0][1] + strlen($match[0][0]));
    } else {
      $this->saveMetaData($name, $template);
    }

    // Return twig source
    return new Source($contents, $name, $template);
  }

  /**
   * @param string $name
   * @return int
   */
  public function getSourceOffset(string $name): int {
    try {
      $data = $this->getMetaData($name);
      return $data['sourceOffset'];
    } catch (Throwable) {
      return 0;
    }
  }


  // Private methods
  // ---------------

  /**
   * @throws Throwable
   */
  private function loadCachedMetaData(): void {
    if (isset($this->_metaData)) {
      return;
    }

    $metaData = Craft::$app->getCache()->get(self::class);
    $this->_metaData = is_array($metaData)
      ? $metaData
      : [];

    if (Config::getInstance()->useTemplateModificationCheck()) {
      foreach ($this->_metaData as $name => $metaData) {
        $path = $metaData['path'];

        if (!is_file($path) || !is_readable($path)) {
          unset($this->_metaData[$name]);
        } elseif ($metaData['mtime'] != filemtime($path)) {
          $this->loadMetaData($name);
        }
      }
    }
  }

  /**
   * @param string $name
   * @return array
   * @throws Throwable
   */
  private function loadMetaData(string $name): array {
    $this->loadCachedMetaData();

    return YamlAwareTemplateLoader::withSiteView(function(View $view) use ($name) {
      // Try to load the template normally, if we have to compile it
      // we'll load the metadata with it
      $view->getTwig()->load($name);

      // We loaded the template but did not get the metadata, this happens
      // if the template is already compiled, so we must fetch the metadata
      // on our own
      if (!isset($this->_metaData[$name])) {
        $this->getSourceContext($name);
      }

      // Still no luck, something went south
      if (!isset($this->_metaData[$name])) {
        throw new Exception(sprintf(
          'Could not load meta data for template `%s`.',
          $name
        ));
      }

      return $this->_metaData[$name];
    });
  }

  /**
   * @param string $name
   * @param string $path
   * @param string|null $yaml
   * @throws Throwable
   */
  private function saveMetaData(string $name, string $path, string $yaml = null): void {
    $name = self::normalizeName($name);
    $this->loadCachedMetaData();

    if (is_null($yaml)) {
      $sourceOffset = 0;
      $preamble = null;
    } else {
      $sourceOffset = count(explode("\n", $yaml)) - 1;
      try {
        $preamble = AbstractSchema::expandConfig(
          Yaml::parse($yaml),
          ['allowStructures' => true]
        );
      } catch (ParseException $error) {
        throw new YamlException($error, $path);
      }
    }

    if (!$this->_hasMetaDataChanged) {
      $this->_hasMetaDataChanged = true;
      register_shutdown_function(function() {
        try {
          Craft::$app->getCache()->set(self::class, $this->_metaData);
        } catch (Throwable) {
          // Ignore this, we are shutting down
        }
      });
    }

    $this->_metaData[$name] = [
      'mtime'        => filemtime($path),
      'name'         => $name,
      'path'         => $path,
      'preamble'     => $preamble,
      'sourceOffset' => $sourceOffset,
    ];
  }


  // Static methods
  // --------------

  /**
   * @param View|null $view
   * @return Environment
   * @throws \yii\base\Exception
   */
  static public function getSiteTwig(View $view = null): Environment {
    return self::withSiteView(function(View $view) {
      $twig = $view->getTwig();
      if (!($twig->getLoader() instanceof YamlAwareTemplateLoader)) {
        $twig->setLoader(new YamlAwareTemplateLoader($view));
      }

      return $twig;
    }, $view);
  }

  /**
   * @param string $name
   * @return string
   */
  static public function normalizeName(string $name): string {
    $name = FileHelper::normalizePath($name, self::SEPARATOR);
    if (str_ends_with($name, '.twig')) {
      $name = substr($name, 0, strlen($name) - 5);
    }

    return $name;
  }

  /**
   * @param callable $callback
   * @param View|null $view
   * @return mixed
   * @throws \yii\base\Exception
   */
  static public function withSiteView(callable $callback, View $view = null): mixed {
    if (is_null($view)) {
      $view = Craft::$app->getView();
    }

    $templateMode = $view->getTemplateMode();
    if ($templateMode == $view::TEMPLATE_MODE_SITE) {
      return $callback($view);
    }

    $view->setTemplateMode($view::TEMPLATE_MODE_SITE);

    try {
      $result = $callback($view);
    } finally {
      $view->setTemplateMode($templateMode);
    }

    return $result;
  }
}
