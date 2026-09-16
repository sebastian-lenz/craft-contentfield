<?php

namespace lenz\contentfield\models\schemas;

use lenz\contentfield\services\schemas\TemplateLoader;

/**
 * Class Qualifier
 */
class Qualifier
{
  /** @var string */
  public const DEFAULT_LOADER = TemplateLoader::NAME_PREFIX;

  /**
   * @param string $name
   * @param string|null $loader
   * @param Qualifier|null $scope
   */
  public function __construct(
    public string $name,
    public string|null $loader = null,
    public Qualifier|null $scope = null,
  ) { }

  /**
   * Deep-clones the scope qualifier so mutating a resolved Qualifier
   * never affects the instance it was cloned from.
   */
  public function __clone(): void {
    if ($this->scope !== null) {
      $this->scope = clone $this->scope;
    }
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return ($this->loader ?? self::DEFAULT_LOADER) . $this->getFullName();
  }

  /**
   * @return string
   */
  public function getFullName(): string {
    $result = $this->name;
    if ($this->scope !== null) {
      $result .= '@' . $this->scope;
    }

    return $result;
  }


  // Static methods
  // --------------

  /**
   * @param string $name
   * @return Qualifier
   */
  static public function parse(string $name): Qualifier {
    $scope = null;
    $loader = null;

    $scopeOffset = strpos($name, '@');
    if ($scopeOffset !== false) {
      $scope = self::parse(substr($name, $scopeOffset + 1));
      $name = substr($name, 0, $scopeOffset);
    }

    $loaderOffset = strpos($name, ':');
    if ($loaderOffset !== false) {
      $loader = trim(substr($name, 0, $loaderOffset + 1));
      $name = substr($name, $loaderOffset + 1);
    }

    return new Qualifier(trim($name), $loader, $scope);
  }

  /**
   * @param AbstractSchema|Qualifier|string $value
   * @return Qualifier
   */
  static public function toQualifier(AbstractSchema|Qualifier|string $value): Qualifier {
    if ($value instanceof Qualifier) {
      return clone $value;
    } elseif ($value instanceof AbstractSchema) {
      $value = $value->qualifier;
    }

    return self::parse($value);
  }

  /**
   * @param string $qualifier
   * @return string
   */
  public static function extractName(string $qualifier): string {
    return self::parse($qualifier)->name;
  }
}
