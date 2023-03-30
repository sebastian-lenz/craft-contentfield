<?php

namespace lenz\contentfield\helpers\colors;

use craft\fields\data\ColorData;

/**
 * Class HSLColor
 */
class HSLColor extends AbstractColor
{
  /**
   * @var float
   */
  public float $alpha = 1;

  /**
   * @var float
   */
  public float $hue = 0;

  /**
   * @var float
   */
  public float $lightness = 0;

  /**
   * @var float
   */
  public float $saturation = 0;


  /**
   * @return string
   */
  public function __toString(): string {
    return $this->toRGB()->getHex();
  }

  /**
   * @param float $value
   * @return $this
   */
  public function brighten(float $value): self {
    $this->lightness = max(0, min(1, $this->lightness * $value));
    return $this;
  }

  /**
   * @return string
   */
  public function getHex(): string {
    return $this->toRGB()->getHex();
  }

  /**
   * @return $this
   */
  public function normalize(): self {
    $this->lightness = max(0, min(1, $this->lightness));
    $this->saturation = max(0, min(1, $this->saturation));

    while ($this->hue < 0) $this->hue += 360;
    while ($this->hue > 360) $this->hue -= 360;
    return $this;
  }

  /**
   * @return float[]
   */
  public function toArray(): array {
    return [
      'h' => $this->hue,
      's' => $this->saturation,
      'l' => $this->lightness,
    ];
  }

  /**
   * @return ColorData
   */
  public function toColorData(): ColorData {
    return $this->toRGB()->toColorData();
  }

  /**
   * @return RGBColor
   */
  public function toRGB(): RGBColor {
    $saturation = max(0, min(1, $this->saturation));
    $lightness = max(0, min(1, $this->lightness));
    $hue = $this->hue / 60;
    if ($hue < 0) $hue = 6 - fmod(-$hue, 6);
    $hue = fmod($hue, 6);

    $c = (1 - abs((2 * $lightness) - 1)) * $saturation;
    $x = $c * (1 - abs(fmod($hue, 2) - 1));
    $m = $lightness - $c / 2;

    $blue = 0;
    $green = 0;
    $red = 0;

    if ($hue < 1) {
      $red = $c;
      $green = $x;
    } elseif ($hue < 2) {
      $red = $x;
      $green = $c;
    } elseif ($hue < 3) {
      $green = $c;
      $blue = $x;
    } elseif ($hue < 4) {
      $green = $x;
      $blue = $c;
    } elseif ($hue < 5) {
      $red = $x;
      $blue = $c;
    } else {
      $red = $c;
      $blue = $x;
    }

    return new RGBColor([
      'red' => round(($red + $m) * 255),
      'green' => round(($green + $m) * 255),
      'blue' => round(($blue + $m) * 255),
    ]);
  }


  // Static methods
  // --------------

  /**
   * @param ColorData $data
   * @return HSLColor
   */
  static public function fromColorData(ColorData $data): HSLColor {
    return self::fromHex($data->getHex());
  }

  /**
   * @param string $hex
   * @return HSLColor
   */
  static public function fromHex(string $hex): HSLColor {
    return RGBColor::fromHex($hex)->toHSL();
  }
}
