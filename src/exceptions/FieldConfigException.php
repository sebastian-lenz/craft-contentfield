<?php

namespace lenz\contentfield\exceptions;

use Exception;
use Symfony\Component\Yaml\Exception\ParseException;
use Throwable;

/**
 * Class FieldConfigException
 */
class FieldConfigException extends Exception
{
  /**
   * @var array
   */
  public $fieldConfiguration;


  /**
   * FieldException constructor.
   *
   * @param array $fieldConfiguration
   * @param string $message
   * @param int $code
   * @param Throwable|null $previous
   */
  public function __construct($fieldConfiguration, $message = "", $code = 0, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);

    $this->fieldConfiguration = $fieldConfiguration;
  }
}
