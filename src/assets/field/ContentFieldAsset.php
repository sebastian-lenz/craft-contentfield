<?php

namespace lenz\contentfield\assets\field;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use craft\web\View;

/**
 * Class ContentFieldAsset
 */
class ContentFieldAsset extends AssetBundle
{
  /**
   * @return void
   */
  public function init() {
    $this->sourcePath = __DIR__ . '/resources';
    $this->depends    = [ CpAsset::class ];
    $this->js         = [ 'vendor.js', 'content-field.js' ];
    $this->css        = [ 'content-field.css' ];

    parent::init();
  }

  /**
   * @inheritDoc
   */
  public function registerAssetFiles($view) {
    parent::registerAssetFiles($view);

    if ($view instanceof View) {
      $this->_registerTranslations($view);
    }
  }


  // Private methods
  // ---------------

  /**
   * @param View $view
   */
  private function _registerTranslations(View $view) {
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
