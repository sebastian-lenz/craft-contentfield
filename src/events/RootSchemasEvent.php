<?php

namespace lenz\contentfield\events;

use craft\base\ElementInterface;
use lenz\contentfield\fields\ContentField;
use yii\base\Event;

/**
 * Class RootSchemasEvent
 */
class RootSchemasEvent extends Event
{
  /**
   * @var ElementInterface
   */
  public $element;

  /**
   * @var ContentField
   */
  public $field;

  /**
   * @var string[]
   */
  public $schemas;
}
