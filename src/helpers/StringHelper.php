<?php

namespace lenz\contentfield\helpers;

/**
 * Class StringHelper
 */
class StringHelper extends \craft\helpers\StringHelper
{
  const CHARACTER_REPLACEMENTS = [
    "\xe2\x80\xa8" => '', // Line Separator, U+2028
    "\xe2\x80\xa9" => '', // Paragraph Separator, U+2029
  ];


  /**
   * @param string $value
   * @return string
   */
  static public function sanitizeString(string $value): string {
    // Remove forbidden characters
    foreach (self::CHARACTER_REPLACEMENTS as $search => $replace) {
      $value = str_replace($search, $replace, $value);
    }

    // Unify line endings
    return trim(preg_replace('/\R/u', "\n", $value));
  }
}
