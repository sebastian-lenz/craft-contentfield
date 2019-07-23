<?php

namespace lenz\contentfield\twig;

use Craft;
use craft\web\twig\Environment;
use craft\web\twig\TemplateLoader;
use craft\web\twig\TemplateLoaderException;
use craft\web\View;
use Exception;
use lenz\contentfield\Config;
use lenz\contentfield\exceptions\YamlException;
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
  private $_hasMetaDataChanged = false;

  /**
   * @var array
   */
  private $_metaData;


  /**
   * @param string $name
   * @return array
   * @throws Throwable
   */
  public function getMetaData($name) {
    $this->loadCachedMetaData();
    if (!isset($this->_metaData[$name])) {
      $this->_metaData[$name] = $this->loadMetaData($name);
    }

    return $this->_metaData[$name];
  }

  /**
   * @param string $name
   * @return array|null
   */
  public function getPreamble($name) {
    try {
      $data = $this->getMetaData($name);
      return $data['preamble'];
    } catch (Throwable $error) {
      return null;
    }
  }

  /**
   * @inheritdoc
   * @throws Throwable
   */
  public function getSourceContext($name) {
    $template = $this->view->resolveTemplate($name);
    if ($template === false || !is_readable($template)) {
      throw new TemplateLoaderException($name,
        Craft::t(
          'app',
          'Tried to read the template at {path}, but could not. Check the permissions.',
          ['path' => $template]
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
  public function getSourceOffset($name) {
    try {
      $data = $this->getMetaData($name);
      return $data['sourceOffset'];
    } catch (Throwable $error) {
      return 0;
    }
  }


  // Private methods
  // ---------------

  /**
   * @throws Throwable
   */
  private function loadCachedMetaData() {
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
  private function loadMetaData($name) {
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
  private function saveMetaData($name, $path, $yaml = null) {
    $this->loadCachedMetaData();

    if (is_null($yaml)) {
      $sourceOffset = 0;
      $preamble = null;
    } else {
      $sourceOffset = count(explode("\n", $yaml)) - 1;
      try {
        $preamble = Yaml::parse($yaml);
      } catch (ParseException $error) {
        throw new YamlException($error, $path);
      }
    }

    if (!$this->_hasMetaDataChanged) {
      $this->_hasMetaDataChanged = true;
      register_shutdown_function(function() {
        Craft::$app->getCache()->set(self::class, $this->_metaData);
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
   * @param View $view
   * @return Environment
   * @throws \yii\base\Exception
   */
  static public function getSiteTwig(View $view) {
    return self::withSiteView(function(View $view) {
      $twig = $view->getTwig();
      if (!($twig->getLoader() instanceof YamlAwareTemplateLoader)) {
        $twig->setLoader(new YamlAwareTemplateLoader($view));
      }

      return $twig;
    }, $view);
  }

  /**
   * @param callable $callback
   * @param View|null $view
   * @return mixed
   * @throws \yii\base\Exception
   */
  static public function withSiteView(callable $callback, View $view = null) {
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
