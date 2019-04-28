<?php

namespace lenz\contentfield\assets\field;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

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
}
