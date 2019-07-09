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
    $view->registerTranslations('contentfield', [
      'ARRAY_MEMBER_DISABLED_COLLAPSE',
      'ARRAY_MEMBER_DISABLED_EXPAND',
      'ARRAY_MEMBER_ENABLED_COLLAPSE',
      'ARRAY_MEMBER_ENABLED_EXPAND',

      'COMMAND_COPY_LABEL',
      'COMMAND_CREATE_LABEL',
      'COMMAND_CUT_LABEL',
      'COMMAND_DELETE_LABEL',
      'COMMAND_EDIT_LABEL',
      'COMMAND_MOVE_DOWN_LABEL',
      'COMMAND_MOVE_UP_LABEL',
      'COMMAND_PASTE_LABEL',

      'FIELD_LINK_NEW_WINDOW',

      'OVERLAY_EDIT_INSTANCE_APPLY',
    ]);
  }
}
