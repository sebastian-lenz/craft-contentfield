<?php

namespace lenz\contentfield\exceptions;

use Exception;
use Symfony\Component\Yaml\Exception\ParseException;
use Throwable;

/**
 * Class TemplateConfigException
 */
class TemplateConfigException extends Exception
{
  /**
   * @var array
   */
  public $templateConfiguration;


  /**
   * FieldException constructor.
   * @param array $templateConfiguration
   * @param string $message
   * @param int $code
   * @param Throwable|null $previous
   */
  public function __construct($templateConfiguration, $message = "", $code = 0, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);

    $this->templateConfiguration = $templateConfiguration;
  }
}
