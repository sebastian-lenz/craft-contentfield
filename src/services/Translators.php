<?php

namespace lenz\contentfield\services;

use craft\helpers\Template;
use lenz\contentfield\events\RegisterTranslatorsEvent;
use lenz\contentfield\Plugin;
use lenz\contentfield\services\translators\AbstractTranslator;
use Throwable;
use yii\base\Component;

/**
 * Class Translators
 */
class Translators extends Component
{
  /**
   * @var AbstractTranslator|null
   */
  private ?AbstractTranslator $_translator;

  /**
   * @var array<class-string<AbstractTranslator>>
   */
  private array $_translators;

  /**
   * Event that will be triggered when looking for available translators.
   */
  const EVENT_REGISTER_TRANSLATORS = 'registerTranslators';


  /**
   * @return AbstractTranslator|null
   */
  public function getTranslator(): ?AbstractTranslator {
    if (!isset($this->_translator)) {
      $this->_translator = $this->createTranslator();
    }

    return $this->_translator;
  }

  /**
   * @return array<class-string<AbstractTranslator>>
   */
  public function getTranslatorTypes(): array {
    if (!isset($this->_translators)) {
      $event = new RegisterTranslatorsEvent();
      $this->trigger(self::EVENT_REGISTER_TRANSLATORS, $event);
      $this->_translators = $event->translators;
    }

    return $this->_translators;
  }

  /**
   * @return string[]
   */
  public function getTranslatorTypeOptions(): array {
    $options = ['' => '(None)'];
    foreach ($this->getTranslatorTypes() as $translator) {
      $options[$translator::getHandle()] = $translator::getDisplayName();
    }

    return $options;
  }

  /**
   * @return array
   * @throws Throwable
   * @noinspection PhpUnused
   */
  public function getTranslatorTypeSettings(): array {
    return array_filter(array_map(function(string $translator) {
      $html = $translator::getSettingsHtml();
      if (is_null($html)) {
        return null;
      }

      return [
        'displayName' => $translator::getDisplayName(),
        'handle' => $translator::getHandle(),
        'html' => Template::raw($html),
      ];
    }, $this->getTranslatorTypes()));
  }

  /**
   * @return bool
   */
  public function hasTranslator(): bool {
    return !is_null($this->getTranslator());
  }


  // Private methods
  // ---------------

  /**
   * @return AbstractTranslator|null
   */
  private function createTranslator(): ?AbstractTranslator {
    $settings = Plugin::getInstance()->getSettings();
    $translators = $this->getTranslatorTypes();
    $handle = $settings->translator;

    foreach ($translators as $translatorClass) {
      if ($translatorClass::getHandle() != $handle) {
        continue;
      }

      $translatorSettings = $settings->getTranslatorSettings($handle);
      return new $translatorClass($translatorSettings);
    }

    return null;
  }
}
