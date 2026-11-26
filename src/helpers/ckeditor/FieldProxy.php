<?php

namespace lenz\contentfield\helpers\ckeditor;

use Craft;
use craft\base\ElementInterface;
use craft\ckeditor\events\ModifyConfigEvent;
use craft\ckeditor\Field;
use craft\ckeditor\helpers\CkeditorConfig;
use craft\ckeditor\Plugin as CkeditorPlugin;
use craft\ckeditor\web\assets\BaseCkeditorPackageAsset;
use craft\ckeditor\web\assets\ckeditor\CkeditorAsset;
use craft\elements\Entry;
use craft\helpers\ArrayHelper;
use craft\web\View;
use Exception;
use ReflectionException;
use ReflectionMethod;
use yii\base\InvalidConfigException;

/**
 * Class FieldProxy
 *
 * Wraps a native CKEditor field (craftcms/ckeditor 5.x) so content fields can
 * reuse its configuration, sanitizing and editor bootstrapping.
 */
class FieldProxy extends Field
{
  /**
   * @var string|null
   */
  private string|null $_configId = null;


  /**
   * FieldProxy constructor.
   *
   * @param array $config
   */
  public function __construct(array $config = []) {
    // Content fields did not offer image uploads in the past, keep it
    // that way unless a config explicitly asks for it.
    $config += [
      'availableTransforms' => null,
      'availableVolumes' => null,
    ];

    parent::__construct($config);
  }

  /**
   * @param mixed $value
   * @param ElementInterface|null $element
   * @param bool $static
   * @return string
   */
  public function getEditorValue(mixed $value, ?ElementInterface $element, bool $static = false): string {
    try {
      return $this->prepValueForInput($value, $element, $static);
    } catch (Exception) {
      return '';
    }
  }

  /**
   * Registers the editor configuration on the current view and returns
   * the id the content field editor uses to look it up.
   *
   * @param ElementInterface|null $element
   * @return string
   * @throws ReflectionException
   * @throws InvalidConfigException
   */
  public function registerJs(?ElementInterface $element = null): string {
    if (isset($this->_configId)) return $this->_configId;
    $this->_configId = uniqid('cke');

    $view = Craft::$app->getView();
    $view->registerAssetBundle(CkeditorAsset::class);

    $event = $this->getBaseConfig($element);
    $removePlugins = ['MediaEmbedToolbar'];
    if (empty($event->baseConfig['transforms'] ?? [])) {
      $removePlugins[] = 'ImageTransforms';
    }

    if (!$this->showWordCount) {
      $removePlugins[] = 'WordCount';
    }

    // Only import the packages that are in use, see Field::_inputHtml()
    $configJs = $this->invokeFieldMethod('configJs');
    [$imports, $pluginRefs, $namespaces] = CkeditorConfig::getImports(
      $event->toolbar,
      $removePlugins,
      isset($this->options) ? null : $configJs,
    );

    CkeditorPlugin::registerCkeditorPackageBundles($view, $namespaces);

    $configPlugins = '[' . implode(',', $pluginRefs) . ']';
    $uiLanguage = BaseCkeditorPackageAsset::getImportCompliantLanguage(BaseCkeditorPackageAsset::uiLanguage());

    $view->registerScriptWithVars(fn(
      $configIdJs,
      $baseConfigJs,
      $toolbarJs,
      $languageJs,
      $removePluginsJs,
    ) => <<<JS
$imports
import coreTranslations from 'ckeditor5/translations/$uiLanguage.js';
import {create} from '@craftcms/ckeditor';

(() => {
  const customConfig = $configJs;
  const config = Object.assign({
    translations: [coreTranslations],
    language: $languageJs,
  }, $baseConfigJs, customConfig, {
    plugins: $configPlugins,
    removePlugins: [
      ...($baseConfigJs?.removePlugins ?? []),
      ...(customConfig?.removePlugins ?? []),
      ...$removePluginsJs,
    ],
  });

  if (!jQuery.isPlainObject(config.toolbar)) {
    config.toolbar = {};
  }
  config.toolbar.items = $toolbarJs;

  // Merge heading options of the base config with custom ones,
  // see https://github.com/craftcms/ckeditor/issues/431
  const baseHeadings = $baseConfigJs?.heading?.options;
  const customHeadings = customConfig?.heading?.options;
  const nativeHeadingModels = ['paragraph', 'heading1', 'heading2', 'heading3', 'heading4', 'heading5', 'heading6'];
  if (baseHeadings && customHeadings && baseHeadings != customHeadings) {
    const headings = {};
    baseHeadings.forEach((heading) => {
      headings[heading.model] = heading;
    });
    customHeadings.forEach((heading) => {
      if (heading.model in headings || !nativeHeadingModels.includes(heading.model)) {
        headings[heading.model] = heading;
      }
    });
    config.heading.options = Object.values(headings);
  }

  // Module scripts run deferred, hand the config over through a queue
  // the content field editor picks up once it is ready.
  const ns = window.lenz || (window.lenz = {});
  (ns.ckeditorQueue || (ns.ckeditorQueue = [])).push([$configIdJs, config, create]);
  if (ns.contentField && ns.contentField.flushCKEditorQueue) {
    ns.contentField.flushCKEditorQueue();
  }
})();
JS,
      [
        $this->_configId,
        $event->baseConfig,
        $event->toolbar,
        [
          'ui' => BaseCkeditorPackageAsset::uiLanguage(),
          'content' => $element?->getSite()->language ?? Craft::$app->language,
          'textPartLanguage' => static::textPartLanguage(),
        ],
        $removePlugins,
      ],
      View::POS_END,
      ['type' => 'module']
    );

    $css = $this->invokeFieldMethod('css');
    if ($css) {
      $view->registerCss(".$this->_configId { $css }");
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
  protected function getBaseConfig(?ElementInterface $element = null): ModifyConfigEvent {
    $toolbar = array_merge($this->toolbar);

    // Nested entries are not supported within content fields
    ArrayHelper::removeValue($toolbar, 'createEntry');

    $user = Craft::$app->getUser()->getIdentity();
    if (!$user || !$this->invokeFieldMethod('isSourceEditingAllowed', $user)) {
      ArrayHelper::removeValue($toolbar, 'sourceEditing');
    }

    $toolbar = array_values($toolbar);
    $transforms = $this->invokeFieldMethod('_transforms');
    $defaultTransform = $this->defaultTransform
      ? Craft::$app->getImageTransforms()->getTransformByUid($this->defaultTransform)
      : null;

    $baseConfig = array_filter([
      'licenseKey' => CkeditorPlugin::getInstance()->getSettings()->getLicenseKey(),
      'defaultTransform' => $defaultTransform?->handle,
      'elementSiteId' => $element?->siteId,
      'accessibleFieldName' => '',
      'describedBy' => '',
      'entryTypeOptions' => [],
      'findAndReplace' => [
        'uiType' => 'dropdown',
      ],
      'nestedElementAttributes' => $element?->id ? array_filter([
        'elementType' => Entry::class,
        'ownerId' => $element->id,
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
          ], $this->headingLevels ?: []),
        ],
      ],
      'image' => [
        'toolbar' => [
          ...(!empty($transforms) ? ['transformImage', '|'] : []),
          'toggleImageCaption',
          'imageTextAlternative',
          '|',
          'imageEditor',
        ],
      ],
      'imageMode' => $this->imageMode,
      'imageSources' => $this->invokeFieldMethod('_imageSources'),
      'imageModalSettings' => $this->invokeFieldMethod('_imageModalSettings'),
      'imageFieldHandle' => $this->getImageField()?->handle,
      'assetSelectionCriteria' => $this->invokeFieldMethod('_assetSelectionCriteria'),
      'linkOptions' => $this->invokeFieldMethod('_linkOptions', $element),
      'advancedLinkFields' => $this->invokeFieldMethod('_advancedLinkFields'),
      'table' => [
        'contentToolbar' => [
          'tableRow',
          'tableColumn',
          'mergeTableCells',
        ],
      ],
      'transforms' => $transforms,
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
      'toolbar' => $toolbar,
    ]);

    $this->trigger(self::EVENT_MODIFY_CONFIG, $event);
    return $event;
  }

  /**
   * Invokes a private method of the native CKEditor field.
   *
   * @param string $name
   * @param mixed ...$args
   * @return mixed
   * @throws ReflectionException
   */
  protected function invokeFieldMethod(string $name, mixed ...$args): mixed {
    return (new ReflectionMethod(Field::class, $name))->invoke($this, ...$args);
  }
}
