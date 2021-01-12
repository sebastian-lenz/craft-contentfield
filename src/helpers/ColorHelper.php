<?php

namespace lenz\contentfield\helpers;

/**
 * Class ColorHelpers
 */
class ColorHelper
{
  /**
   * @param float|int $red
   * @param float|int $green
   * @param float|int $blue
   * @return array|float[]
   */
  static public function toHsl($red, $green, $blue): array {
    $red = max(0, min(1, $red / 255));
    $green = max(0, min(1, $green / 255));
    $blue = max(0, min(1, $blue / 255));

    $max = max($red, $green, $blue);
    $min = min($red, $green, $blue);
    $lightness = ($max + $min) / 2;
    $chroma = $max - $min;

    if ($chroma == 0) {
      return ['h' => 0, 's' => 0, 'l' => $lightness];
    }

    if ($red == $max) {
      $hue = fmod(($green - $blue) / $chroma, 6);
      if ($blue > $green) $hue += 6;
    } else if ($green == $max) {
      $hue = 2 + ($blue - $red) / $chroma;
    } else {
      $hue = 4 + ($red - $green) / $chroma;
    }

    return [
      'h' => 60 * $hue,
      's' => $chroma / (1 - abs(2 * $lightness - 1)),
      'l' => $lightness
    ];
  }


  /**
   * @param float|int $red
   * @param float|int $green
   * @param float|int $blue
   * @return array|float[]
   */
  static public function toHsv($red, $green, $blue): array {
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
