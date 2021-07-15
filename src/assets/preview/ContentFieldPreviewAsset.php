<?php

namespace lenz\contentfield\assets\preview;

use craft\web\AssetBundle;

/**
 * Class ContentFieldPreviewAsset
 */
class ContentFieldPreviewAsset extends AssetBundle
{
  /**
   * @return void
   */
  public function init() {
    $this->sourcePath = __DIR__ . '/resources';
    $this->js         = [ 'content-field-preview.js' ];
    $this->css        = [ 'content-field-preview.css' ];

    parent::init();
  }
}
