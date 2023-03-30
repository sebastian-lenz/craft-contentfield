<?php

namespace lenz\contentfield\helpers;

use lenz\contentfield\helpers\colors\RGBColor;

/**
 * Class ColorHelpers
 */
class ColorHelper
{
  /**
   * @param float $red
   * @param float $green
   * @param float $blue
   * @return float[]
   * @noinspection DuplicatedCode
   */
  static public function toHsl(float $red, float $green, float $blue): array {
    return (new RGBColor([
      'blue' => $blue,
      'green' => $green,
      'red' => $red,
    ]))->toHSL()->toArray();
  }


  /**
   * @param float $red
   * @param float $green
   * @param float $blue
   * @return float[]
   * @noinspection DuplicatedCode
   */
  static public function toHsv(float $red, float $green, float $blue): array {
    $red = max(0, min(1, $red / 255));
    $green = max(0, min(1, $green / 255));
    $blue = max(0, min(1, $blue / 255));

    $max = max($red, $green, $blue);
    $min = min($red, $green, $blue);
    $chroma = $max - $min;

    if ($chroma == 0) {
      return ['h' => 0, 's' => 0, 'v' => $max];
    }

    if ($red == $min) {
      $hue = 3 - (($green - $blue) / $chroma);
    } elseif ($blue == $min) {
      $hue = 1 - (($red - $green) / $chroma);
    } else {
      $hue = 5 - (($blue - $red) / $chroma);
    }

    return [
      'h' => 60 * $hue,
      's' => $chroma / $max,
      'v' => $max
    ];
  }
}
