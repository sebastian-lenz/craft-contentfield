<?php

namespace lenz\contentfield\events;

use lenz\contentfield\services\translators\AbstractTranslator;
use lenz\contentfield\services\translators\AzureTranslator;
use lenz\contentfield\services\translators\GoogleTranslator;
use yii\base\Event;

/**
 * Class RegisterTranslatorsEvent
 */
class RegisterTranslatorsEvent extends Event
{
  /**
   * The list of available translator classes.
   * @var array<class-string<AbstractTranslator>>
   */
  public array $translators = [
    AzureTranslator::class,
    GoogleTranslator::class,
  ];


  /**
   * RegisterTranslatorsEvent constructor.
   * @param array $config
   */
  public function __construct(array $config = []) {
    parent::__construct($config);
  }
}
