<?php

namespace lenz\contentfield\helpers\colors;

use craft\fields\data\ColorData;

/**
 * Class RGBColor
 *
 * @property string $hex
 */
class RGBColor extends AbstractColor
{
  /**
   * @var float
   */
  public float $alpha = 1;

  /**
   * @var int
   */
  public int $blue = 0;

  /**
   * @var int
   */
  public int $green = 0;

  /**
   * @var int
   */
  public int $red = 0;


  /**
   * @return string
   */
  public function __toString(): string {
    return $this->getHex();
  }

  /**
   * @return string
   */
  public function getHex(): string {
    return sprintf("#%02x%02x%02x", $this->red, $this->green, $this->blue);
  }

  /**
   * @return $this
   */
  public function normalize(): self {
    $this->blue = max(0, min(255, round($this->blue)));
    $this->green = max(0, min(255, round($this->green)));
    $this->red = max(0, min(255, round($this->red)));
    return $this;
  }

  /**
   * @param string $value
   * @return $this
   */
  public function setHex(string $value): self {
    if (!str_starts_with($value, '#')) $value = '#' . $value;

    $this->red = hexdec(substr($value, 1, 2));
    $this->green = hexdec(substr($value, 3, 2));
    $this->blue = hexdec(substr($value, 5, 2));
    return $this;
  }

  /**
   * @return float[]
   */
  public function toArray(): array {
    return [
      'r' => $this->red,
      'g' => $this->green,
      'b' => $this->blue,
    ];
  }

  /**
   * @return ColorData
   */
  public function toColorData(): ColorData {
    return new ColorData($this->getHex());
  }

  /**
   * @return HSLColor
   */
  public function toHSL(): HSLColor {
    $red = max(0, min(1, $this->red / 255));
    $green = max(0, min(1, $this->green / 255));
    $blue = max(0, min(1, $this->blue / 255));

    $max = max($red, $green, $blue);
    $min = min($red, $green, $blue);
    $lightness = ($max + $min) / 2;
    $chroma = $max - $min;

    if ($chroma == 0) {
      return new HSLColor([
        'alpha' => $this->alpha,
        'lightness' => $lightness,
      ]);
    }

    if ($red == $max) {
      $hue = fmod(($green - $blue) / $chroma, 6);
      if ($blue > $green) $hue += 6;
    } else if ($green == $max) {
      $hue = 2 + ($blue - $red) / $chroma;
    } else {
      $hue = 4 + ($red - $green) / $chroma;
    }

    return new HSLColor([
      'alpha' => $this->alpha,
      'hue' => 60 * $hue,
      'lightness' => $lightness,
      'saturation' => $chroma / (1 - abs(2 * $lightness - 1)),
    ]);
  }


  // Static methods
  // --------------

  /**
   * @param ColorData $data
   * @return RGBColor
   */
  static public function fromColorData(ColorData $data): RGBColor {
    return self::fromHex($data->getHex());
  }

  /**
   * @param string $hex
   * @return RGBColor
   */
  static public function fromHex(string $hex): RGBColor {
    return (new RGBColor())->setHex($hex);
  }
}
