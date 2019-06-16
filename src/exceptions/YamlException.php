<?php

namespace lenz\contentfield\exceptions;

use Exception;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Class YamlException
 */
class YamlException extends Exception
{
  /**
   * YamlException constructor.
   * @param ParseException $originalException
   * @param string $file
   */
  public function __construct(ParseException $originalException, string $file) {
    parent::__construct($originalException->getMessage(), $originalException->getCode());

    $this->file = $file;
    $this->line = $originalException->getParsedLine();
  }
}
