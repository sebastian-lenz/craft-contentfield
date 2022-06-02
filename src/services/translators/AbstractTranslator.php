<?php

namespace lenz\contentfield\services\translators;

use lenz\contentfield\Plugin;
use Throwable;
use yii\base\BaseObject;

/**
 * Class AbstractTranslator
 */
abstract class AbstractTranslator extends BaseObject
{
  /**
   * @param string $sourceLanguage
   * @param string $targetLanguage
   * @param string $message
   * @return string|null
   */
  abstract function translate(string $sourceLanguage, string $targetLanguage, string $message): ?string;


  // Static methods
  // --------------

  /**
   * @return string
   */
  abstract static function getDisplayName(): string;

  /**
   * @return string
   */
  abstract static function getHandle(): string;

  /**
   * @return array
   */
  static function getSettings(): array {
    return Plugin::getInstance()
      ->getSettings()
      ->getTranslatorSettings(static::getHandle());
  }

  /**
   * @return string|null
   * @throws Throwable
   */
  static function getSettingsHtml(): ?string {
    return null;
  }
}
