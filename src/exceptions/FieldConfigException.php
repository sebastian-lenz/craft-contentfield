<?php

namespace lenz\contentfield\exceptions;

use Exception;
use Throwable;

/**
 * Class FieldConfigException
 */
class FieldConfigException extends Exception
{
  /**
   * @var array
   */
  public array $fieldConfiguration;


  /**
   * FieldException constructor.
   *
   * @param array $fieldConfiguration
   * @param string $message
   * @param int $code
   * @param Throwable|null $previous
   */
  public function __construct(array $fieldConfiguration, string $message = '', int $code = 0, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);

    $this->fieldConfiguration = $fieldConfiguration;
  }
}
