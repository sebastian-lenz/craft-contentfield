<?php

namespace lenz\contentfield\events;

use lenz\contentfield\services\OEmbeds;
use lenz\contentfield\services\oembeds\Endpoint;
use lenz\craft\utils\models\Url;
use yii\base\Event;

/**
 * Class OEmbedUrlEvent
 *
 * @property array $data
 * @property OEmbeds $sender
 */
class OEmbedUrlEvent extends Event
{
  /**
   * @var string
   */
  public string $embedClass;

  /**
   * @var Endpoint
   */
  public Endpoint $endpoint;

  /**
   * @var Url
   */
  public Url $url;
}
