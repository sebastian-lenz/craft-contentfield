<?php

namespace lenz\contentfield\services;

use League\CommonMark\CommonMarkConverter;
use lenz\contentfield\events\CommonMarkEvent;
use yii\base\Component;

/**
 * Class CommonMark
 */
class CommonMark extends Component
{
  /**
   * @var CommonMarkConverter
   */
  private $_converter;

  /**
   * Triggered when a common mark environment is being setup.
   */
  const COMMON_MARK_EVENT = 'commonMark';


  /**
   * CommonMark constructor.
   */
  public function __construct() {
    parent::__construct();

    $event = new CommonMarkEvent();
    $this->trigger(self::COMMON_MARK_EVENT, $event);

    $this->_converter = new CommonMarkConverter(
      $event->config,
      $event->environment
    );
  }

  /**
   * @param string $value
   * @return string
   */
  public function toHtml(string $value) {
    return $this->_converter->convertToHtml($value);
  }
}
