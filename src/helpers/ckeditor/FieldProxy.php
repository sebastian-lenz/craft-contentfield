<?php

namespace lenz\contentfield\helpers\ckeditor;

use Craft;
use craft\base\ElementInterface;
use craft\ckeditor\events\ModifyConfigEvent;
use craft\ckeditor\Field;
use craft\ckeditor\web\assets\BaseCkeditorPackageAsset;
use craft\ckeditor\web\assets\ckeditor\CkeditorAsset;
use craft\elements\Entry;
use craft\helpers\ArrayHelper;
use craft\helpers\Json;
use Exception;
use ReflectionClass;
use ReflectionException;
use yii\base\InvalidConfigException;
use yii\web\View as ViewAlias;

/**
 * Class FieldProxy
 */
class FieldProxy extends Field
{
  /**
   * @phpstan-var ReflectionClass
   */
  public ReflectionClass $reflection;

  /**
   * @phpstan-var string|null
   */
  private string|null $_configId = null;


  /**
   * RedactorSettings constructor.
   * @param array $config
   */
  public function __construct(array $config = []) {
    parent::__construct($config);

    $this->reflection = new ReflectionClass($this);
  }

  /**
   * @phpstan-param $value
   * @phpstan-param ElementInterface|null $element
   * @phpstan-param bool $static
   * @phpstan-return string
   */
  public function getEditorValue($value, ?ElementInterface $element, bool $static = false): string {
    try {
      $method = $this->reflection->getMethod('prepValueForInput');
      return $method->invoke($this, $value, $element, $static);
    } catch (Exception) {
      return '';
    }
  }

  /**
   * @phpstan-param ElementInterface|null $element
   * @phpstan-return string
   * @throws ReflectionException
   * @throws InvalidConfigException
   */
  public function registerJs(ElementInterface $element = null): string {
    if (isset($this->_configId)) return $this->_configId;
    $this->_configId = uniqid('cke');

    $event = $this->getBaseConfig($element);
    $ckeConfig = $event->ckeConfig;

    if (isset($ckeConfig->options)) {
      // translate the placeholder text
      if (isset($ckeConfig->options['placeholder']) && is_string($ckeConfig->options['placeholder'])) {
        $ckeConfig->options['placeholder'] = Craft::t('site', $ckeConfig->options['placeholder']);
      }

      $configOptionsJs = Json::encode($ckeConfig->options);
    } elseif (isset($ckeConfig->js)) {
      $configOptionsJs = <<<JS
(() => {
  $ckeConfig->js
})()
JS;
    } else {
      $configOptionsJs = '{}';
    }

    $configIdJs = Json::encode($this->_configId);
    $baseConfigJs = Json::encode($event->baseConfig);
    $toolbarJs = Json::encode($event->toolbar);
    $languageJs = Json::encode([
      'ui' => BaseCkeditorPackageAsset::uiLanguage(),
      'content' => $element?->getSite()->language ?? Craft::$app->language,
      'textPartLanguage' => static::textPartLanguage(),
    ]);
    $showWordCountJs = Json::encode($this->showWordCount);

    $view = Craft::$app->getView();
    $view->registerAssetBundle(CkeditorAsset::class);
    $view->registerJs(<<<JS
(($) => {
  const config = Object.assign($baseConfigJs, $configOptionsJs);
  if (!jQuery.isPlainObject(config.toolbar)) {
    config.toolbar = {};
  }
  config.toolbar.items = $toolbarJs;
  if (!jQuery.isPlainObject(config.language)) {
    config.language = {};
  }
  config.language = Object.assign($languageJs, config.language);
  const extraRemovePlugins = [];
  if (!$showWordCountJs) {
    extraRemovePlugins.push('WordCount');
  }
  if (extraRemovePlugins.length) {
    if (typeof config.removePlugins === 'undefined') {
      config.removePlugins = [];
    }
    config.removePlugins.push(...extraRemovePlugins);
  }
  lenz.contentField.registerCKEditor($configIdJs, config);
})(jQuery)
JS,
      ViewAlias::POS_END,
    );

    if ($ckeConfig->css) {
      $view->registerCss($ckeConfig->css);
    }

    return $this->_configId;
  }


  // Protected methods
  // -----------------

  /**
   * @param ElementInterface|null $element
   * @return ModifyConfigEvent
   * @throws ReflectionException
   */
  protected function getBaseConfig(ElementInterface $element = null): ModifyConfigEvent {
    $ckeConfig = $this->getCKEditorConfig();
    $toolbar = array_merge($ckeConfig->toolbar);
    if (!$this->enableSourceEditingForNonAdmins && !Craft::$app->getUser()->getIsAdmin()) {
      ArrayHelper::removeValue($toolbar, 'sourceEditing');
    }

    $toolbar = array_values($toolbar);

    $baseConfig = array_filter([
      'defaultTransform' => null,
      'elementSiteId' => $element?->siteId,
      'accessibleFieldName' => '',
      'describedBy' => '',
      'entryTypeOptions' => [],
      'createButtonLabel' => '',
      'findAndReplace' => [
        'uiType' => 'dropdown',
      ],
      'nestedElementAttributes' => $element?->id ? array_filter([
        'elementType' => Entry::class,
        'ownerId' => $element->id,
        'fieldId' => $this->id,
        'siteId' => Entry::isLocalized() ? $element->siteId : null,
      ]) : null,
      'heading' => [
        'options' => [
          [
            'model' => 'paragraph',
            'title' => 'Paragraph',
            'class' => 'ck-heading_paragraph',
          ],
          ...array_map(fn(int $level) => [
            'model' => "heading$level",
            'view' => "h$level",
            'title' => "Heading $level",
            'class' => "ck-heading_heading$level",
          ], $ckeConfig->headingLevels ?: []),
        ],
      ],
      'image' => [
        'toolbar' => ['toggleImageCaption', 'imageTextAlternative'],
      ],
      'assetSources' => [],
      'assetSelectionCriteria' => [],
      'linkOptions' => $this->getLinkOptions($element),
      'table' => [
        'contentToolbar' => [
          'tableRow',
          'tableColumn',
          'mergeTableCells',
        ],
      ],
      'transforms' => [],
      'ui' => [
        'viewportOffset' => ['top' => 50],
        'poweredBy' => [
          'position' => 'inside',
          'label' => '',
        ],
      ],
    ]);

    // Give plugins/modules a chance to modify the config
    $event = new ModifyConfigEvent([
      'baseConfig' => $baseConfig,
      'ckeConfig' => $ckeConfig,
      'toolbar' => $toolbar,
    ]);

    $this->trigger(self::EVENT_MODIFY_CONFIG, $event);
    return $event;
  }

  /**
   * @phpstan-return object
   * @throws ReflectionException
   */
  protected function getCKEditorConfig(): object {
    $method = $this->reflection->getMethod('_ckeConfig');
    return $method->invoke($this);
  }

  /**
   * @phpstan-param ElementInterface|null $element
   * @phpstan-return array
   * @throws ReflectionException
   */
  protected function getLinkOptions(?ElementInterface $element): array {
    $method = $this->reflection->getMethod('_linkOptions');
    return $method->invoke($this, $element);
  }
}
