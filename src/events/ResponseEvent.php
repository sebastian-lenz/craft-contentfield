<?php

namespace lenz\contentfield\events;

use craft\web\Response;
use yii\base\Event;

/**
 * Class ResponseEvent
 */
class ResponseEvent extends Event
{
  /**
   * @var Response
   */
  public Response $response;
}
