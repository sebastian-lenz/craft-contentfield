<?php

namespace lenz\contentfield\services;

use craft\helpers\Template;
use lenz\contentfield\events\RegisterTranslatorsEvent;
use lenz\contentfield\Plugin;
use lenz\contentfield\services\translators\AbstractTranslator;
use lenz\contentfield\services\translators\AzureTranslator;
use lenz\contentfield\services\translators\GoogleTranslator;
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
  private $_translator;

  /**
   * @var AbstractTranslator[]
   */
  private $_translators;

  /**
   * Event that will be triggered when looking for available translators.
   */
  const EVENT_REGISTER_TRANSLATORS = 'registerTranslators';


  /**
   * @return AbstractTranslator|null
   */
  public function getTranslator() {
    if (!isset($this->_translator)) {
      $settings    = Plugin::getInstance()->getSettings();
      $translators = $this->getTranslatorTypes();
      $translator  = null;
      $handle      = $settings->translator;

      foreach ($translators as $translatorClass) {
        if ($translatorClass::getHandle() == $handle) {
          $translatorSettings = $settings->getTranslatorSettings($handle);
          $translator         = new $translatorClass($translatorSettings);
          break;
        }
      }

      $this->_translator = $translator;
    }

    return $this->_translator;
  }

  /**
   * @return AbstractTranslator[]
   */
  public function getTranslatorTypes() {
    if (!isset($this->_translators)) {
      $event = new RegisterTranslatorsEvent([
        'translators' => [
          AzureTranslator::class,
          GoogleTranslator::class,
        ],
      ]);

      $this->trigger(self::EVENT_REGISTER_TRANSLATORS, $event);
      $this->_translators = $event->translators;
    }

    return $this->_translators;
  }

  /**
   * @return string[]
   */
  public function getTranslatorTypeOptions() {
    $options = [
      '' => '(None)',
    ];

    foreach ($this->getTranslatorTypes() as $translator) {
      $options[$translator::getHandle()] = $translator::getDisplayName();
    }

    return $options;
  }

  /**
   * @return array
   * @throws Throwable
   */
  public function getTranslatorTypeSettings() {
    $result = [];

    foreach ($this->getTranslatorTypes() as $translator) {
      $html = $translator::getSettingsHtml();
      if (!is_null($html)) {
        $result[] = [
          'displayName' => $translator::getDisplayName(),
          'handle'      => $translator::getHandle(),
          'html'        => Template::raw($html),
        ];
      }
    }

    return $result;
  }

  /**
   * @return bool
   */
  public function hasTranslator() {
    return !is_null($this->getTranslator());
  }
}
