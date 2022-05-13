<?php

namespace lenz\contentfield\exceptions;

use Exception;
use Throwable;

/**
 * Class TemplateConfigException
 */
class TemplateConfigException extends Exception
{
  /**
   * @var array
   */
  public array $templateConfiguration;


  /**
   * FieldException constructor.
   *
   * @param array $templateConfiguration
   * @param string $message
   * @param int $code
   * @param Throwable|null $previous
   */
  public function __construct(array $templateConfiguration, string $message = '', int $code = 0, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);

    $this->templateConfiguration = $templateConfiguration;
  }
}
