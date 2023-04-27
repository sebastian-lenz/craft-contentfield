<?php

namespace lenz\contentfield\events;

use lenz\contentfield\services\oembeds\YouTubeEmbed;
use yii\base\Event;

/**
 * Class OEmbedDefinitionsEvent
 */
class OEmbedDefinitionsEvent extends Event
{
  /**
   * @var array
   */
  public array $definitions =  [
    'podigee' => [
      'provider_name' => 'Podigee',
      'provider_url' => 'https://www.podigee.com/',
      'endpoints' => [
        [
          'schemes' => [
            'http://*.podigee.io/*',
            'https://*.podigee.io/*',
          ],
          'url' => 'https://embed.podigee.com/oembed',
        ]
      ]
    ],
    'youtube' => [
      'provider_name' => 'YouTube',
      'provider_url' => 'https://www.youtube.com/',
      'endpoints' => [
        [
          'embed_class' => YouTubeEmbed::class,
          'schemes' => [
            'http://youtu.be/*',
            'http://www.youtube.com/*',
            'https://youtu.be/*',
            'https://www.youtube.com/*',
          ],
          'url' => 'https://www.youtube.com/oembed',
        ]
      ]
    ]
  ];
}
