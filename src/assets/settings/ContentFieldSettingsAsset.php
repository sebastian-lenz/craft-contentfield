<?php

namespace lenz\contentfield\assets\settings;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * Class ContentFieldSettingsAsset
 */
class ContentFieldSettingsAsset extends AssetBundle
{
  /**
   * @return void
   */
  public function init() {
    $this->sourcePath = __DIR__ . '/resources';
    $this->depends    = [ CpAsset::class ];
    $this->js         = [ 'content-field-cp.js' ];
    $this->css        = [ 'content-field-cp.css' ];

    parent::init();
  }
}
