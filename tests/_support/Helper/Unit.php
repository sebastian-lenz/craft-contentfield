<?php

/** @noinspection PhpIllegalPsrClassPathInspection */
namespace Helper;

use Codeception\Module;
use PHPUnit\Framework\Constraint\IsType;
use PHPUnit\Framework\Constraint\LogicalOr;

/**
 * Class Unit
 */
class Unit extends Module
{
  /**
   * @param array $members
   * @param mixed $array
   */
  public function assertArrayMembers($members, $array) {
    foreach ($members as $key => $constraints) {
      $this->assertArrayHasKey($key, $array);

      if (is_array($constraints)) {
        $message = sprintf('Array member %s is of type %s', $key, implode('|', $constraints));
        $types = array_map(function($constraint) {
          return new IsType($constraint);
        }, $constraints);
        $this->assertThat($array[$key], LogicalOr::fromConstraints(...$types), $message);
      } else {
        $message = sprintf('Array member %s is of type %s', $key, $constraints);
        $this->assertThat($array[$key], new IsType($constraints), $message);
      }
    }
  }
}
