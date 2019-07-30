<?php

namespace lenz\contentfield\events;

use League\CommonMark\Environment;
use League\CommonMark\Extras\CommonMarkExtrasExtension;
use yii\base\Event;

/**
 * Class CommonMarkEvent
 */
class CommonMarkEvent extends Event
{
  /**
   * @var array
   */
  public $config = [];

  /**
   * @var Environment
   */
  public $environment;


  /**
   * CommonMarkEvent constructor.
   *
   * @param array $config
   */
  public function __construct($config = []) {
    parent::__construct($config);

    $environment = Environment::createCommonMarkEnvironment();
    $environment->addExtension(new CommonMarkExtrasExtension());
    $this->environment = $environment;
  }
}
