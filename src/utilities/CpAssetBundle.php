<?php

namespace contentfield\utilities;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * Class CpAdminAssetBundle
 * @package typedlinkfield\utilities
 */
class CpAssetBundle extends AssetBundle
{
  /**
   * @return void
   */
  public function init() {
    $this->sourcePath = dirname(__DIR__) . '/resources';
    $this->depends    = [ CpAsset::class ];
    $this->js         = [ 'vendor.js', 'content-field.js' ];
    $this->css        = [ 'content-field.css' ];

    parent::init();
  }
}
