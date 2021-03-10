<?php

use craft\volumes\Local;
use crafttests\fixtures\VolumesFixture;

return [
  'basic-volume' => [
    'id' => '1000',
    'name' => 'Test volume 1',
    'handle' => 'testVolume1',
    'type' => Local::class,
    'url' => null,
    'hasUrls' => true,
    'settings' => json_encode([
      'path' => dirname(__FILE__, 3) . '/_data/assets/volume-folder-1/',
      'url' => VolumesFixture::BASE_URL
    ]),
    'sortOrder' => 5,
    'fieldLayoutType' => 'volume_field_layout',
    'uid' => 'volume-1000----------------------uid',
  ],
];
