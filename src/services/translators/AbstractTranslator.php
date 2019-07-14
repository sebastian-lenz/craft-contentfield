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
  abstract function translate($sourceLanguage, $targetLanguage, $message);


  // Static methods
  // --------------

  /**
   * @return string
   */
  abstract static function getDisplayName();

  /**
   * @return string
   */
  abstract static function getHandle();

  /**
   * @return array
   */
  static function getSettings() {
    return Plugin::getInstance()
      ->getSettings()
      ->getTranslatorSettings(static::getHandle());
  }

  /**
   * @return string|null
   * @throws Throwable
   */
  static function getSettingsHtml() {
    return null;
  }
}
