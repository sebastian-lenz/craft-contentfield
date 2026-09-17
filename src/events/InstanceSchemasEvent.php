<?php

namespace lenz\contentfield\events;

use craft\base\ElementInterface;
use Illuminate\Support\Arr;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\services\Schemas;
use yii\base\Event;

/**
 * Class InstanceSchemasEvent
 */
class InstanceSchemasEvent extends Event
{
  /**
   * @var ElementInterface|null
   */
  public ?ElementInterface $element;

  /**
   * @var InstanceField
   */
  public InstanceField $field;

  /**
   * @var string[]
   */
  private array $_qualifiers;

  /**
   * @param array $config
   */
  public function __construct(array $config) {
    $this->_qualifiers = Arr::pull($config, 'qualifiers', []);
    parent::__construct($config);
  }

  /**
   * @return string[]
   */
  public function getQualifiers(): array {
    return $this->_qualifiers;
  }

  /**
   * @param string $value
   * @param bool $isRegExp
   * @return $this
   */
  public function remove(string $value, bool $isRegExp = false): self {
    if (!$isRegExp && Schemas::isPattern($value)) {
      $value = Schemas::toPattern($value);
      $isRegExp = true;
    }

    $this->_qualifiers = array_filter($this->_qualifiers,
      fn(string $qualifier) => $isRegExp
        ? !preg_match($value, $qualifier)
        : $qualifier !== $value
    );

    return $this;
  }
}
