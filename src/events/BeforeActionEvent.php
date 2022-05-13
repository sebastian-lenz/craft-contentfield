<?php

namespace lenz\contentfield\events;

use yii\base\ActionEvent;
use yii\base\Event;

/**
 * Class BeforeActionEvent
 */
class BeforeActionEvent extends Event
{
  /**
   * @var bool
   */
  public bool $isPreviewRequest;

  /**
   * @var ActionEvent
   */
  public ActionEvent $originalEvent;

  /**
   * @var string|null
   */
  public ?string $requestedUuid;
}
