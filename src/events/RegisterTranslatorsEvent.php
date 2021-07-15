<?php

namespace lenz\contentfield\events;

use lenz\contentfield\services\translators\AbstractTranslator;
use yii\base\Event;

/**
 * Class RegisterTranslatorsEvent
 */
class RegisterTranslatorsEvent extends Event
{
  /**
   * The list of available translator classes.
   * @var AbstractTranslator[]
   */
  public $translators;


  /**
   * RegisterTranslatorsEvent constructor.
   * @param array $config
   */
  public function __construct(array $config = []) {
    parent::__construct($config);
  }
}
