<?php

namespace lenz\contentfield\tests\unit\fieldTypes\helpers;

use lenz\contentfield\models\enumerations\EnumerationInterface;

/**
 * Class CustomEnumeration
 */
class CustomEnumeration implements EnumerationInterface
{
  /**
   * @var array
   */
  public $config;


  /**
   * CustomEnumeration constructor.
   * @param array $config
   */
  public function __construct(array $config) {
    $this->config = $config;
  }

  /**
   * @inheritDoc
   */
  function getOptions(): array {
    return [
      ['key' => 'a', 'label' => 'Option A'],
      ['key' => 'b', 'label' => 'Option B'],
    ];
  }
}
