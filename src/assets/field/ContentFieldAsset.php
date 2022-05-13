<?php

namespace lenz\contentfield\assets\field;

use craft\helpers\App;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use craft\web\View;
use lenz\contentfield\Plugin;

/**
 * Class ContentFieldAsset
 */
class ContentFieldAsset extends AssetBundle
{
  /**
   * @return void
   */
  public function init(): void {
    $this->sourcePath = __DIR__ . '/resources';
    $this->depends = [CpAsset::class];
    $this->js = ['vendor.js', 'content-field.js'];
    $this->css = ['content-field.css'];

    $config = Plugin::getInstance()->getSettings();
    if (isset($config->cpCssFile) && !empty($config->cpCssFile)) {
      $this->css[] = App::parseEnv($config->cpCssFile);
    }

    parent::init();
  }

  /**
   * @inheritDoc
   */
  public function registerAssetFiles($view): void {
    parent::registerAssetFiles($view);

    if ($view instanceof View) {
      $this->registerTranslations($view);
    }
  }


  // Private methods
  // ---------------

  /**
   * @param View $view
   */
  private function registerTranslations(View $view): void {
    $i18nFile = implode(DIRECTORY_SEPARATOR, [
      dirname(__DIR__, 2),
      'translations',
      'de',
      'contentfield.php'
    ]);

    $translations = require($i18nFile);
    $view->registerTranslations('contentfield', array_keys($translations));
  }
}
