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
  public ElementInterface $element;

  /**
   * @var ContentField
   */
  public ContentField $field;

  /**
   * @var string[]
   */
  public array $schemas;
}
