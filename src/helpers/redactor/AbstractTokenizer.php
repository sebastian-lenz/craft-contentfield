<?php

namespace lenz\contentfield\helpers\redactor;

use craft\helpers\StringHelper;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\models\values\RedactorValue;
use Throwable;

/**
 * class AbstractTokenizer
 */
abstract class AbstractTokenizer
{
  /**
   * @var string
   */
  protected string $_rawContent;

  /**
   * @var string
   */
  protected string $_compiledContent;


  /**
   * @param string $content
   */
  public function __construct(string $content) {
    $this->_rawContent = $content;
  }

  /**
   * @return string
   */
  public function getCompiledContent(): string {
    if (!isset($this->_compiledContent)) {
      if (!$this->hasRefs()) {
        $this->_compiledContent = $this->_rawContent;
      } else {
        $this->_compiledContent = $this->compile();
      }
    }

    return $this->_compiledContent;
  }


  /**
   * @return string
   */
  public function getRawContent(): string {
    return $this->_rawContent;
  }

  /**
   * @return bool
   */
  public function hasRefs(): bool {
    return StringHelper::contains($this->_rawContent, '{');
  }

  /**
   * @param ReferenceMap $map
   * @return ReferenceMap
   */
  public function registerReferences(ReferenceMap $map): ReferenceMap {
    return $map;
  }


  // Protected methods
  // -----------------

  /**
   * @return string
   */
  abstract protected function compile(): string;


  // Static methods
  // --------------

  /**
   * @param RedactorValue $value
   * @param string $data
   * @param bool $forceNative
   * @return AbstractTokenizer
   */
  static public function create(RedactorValue $value, string $data, bool $forceNative): AbstractTokenizer {
    try {
      if (!$forceNative) {
        return new CustomTokenizer($value, $data);
      }
    } catch (Throwable) {
      // Ignore this
    }

    return new NativeTokenizer($data);
  }
}
