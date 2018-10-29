<?php

namespace contentfield\utilities;

use craft\base\ElementInterface;

/**
 * Class DefaultLocations
 */
class DefaultLocations {
  /**
   * @param ElementInterface|null $element
   * @return array
   */
  static public function get(ElementInterface $element = null) {
    $language = null;
    try {
      $language = $element->getSite()->language;
    } catch (\Throwable $error) { }

    switch ($language) {
      case 'de_DE': return ['latitude' => 52.51666667, 'longitude' => 13.4];
    }

    return [];
  }
}
