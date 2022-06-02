<?php

namespace lenz\contentfield;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\helpers\FileHelper;
use lenz\contentfield\twig\Extension;
use Throwable;
use yii\caching\FileCache;

/**
 * Class Plugin
 *
 * @property services\definitions\FieldDefinitions $fields
 * @property services\FieldUsage $fieldUsage
 * @property FileCache $imageTagCache
 * @property services\definitions\ImageTagDefinitions $imageTags
 * @property services\OEmbeds $oembeds
 * @property services\Relations $relations
 * @property services\Schemas $schemas
 * @property services\definitions\StructureDefinitions $structures
 * @property services\Translators $translators
 * @method Config getSettings()
 */
class Plugin extends BasePlugin
{
  /**
   * @var bool
   */
  public bool $hasCpSettings = true;

  /**
   * @inheritdoc
   */
  public string $schemaVersion = '1.1.3';

  /**
   * @var bool
   */
  static bool $IS_ELEMENT_PREVIEW = false;

  /**
   * @var string
   */
  static string $TRANSLATION_CATEGORY = 'site';

  /**
   * @var string
   */
  static string $UUID_PARAM = 'content-uuid';


  /**
   * @return void
   */
  public function init(): void {
    parent::init();

    $this->setComponents([
      'fields' => services\definitions\FieldDefinitions::class,
      'fieldUsage' => services\FieldUsage::class,
      'imageTagCache' => [
        'class' => FileCache::class,
        'cachePath' => '@runtime/cache-imagetags'
      ],
      'imageTags' => services\definitions\ImageTagDefinitions::class,
      'oembeds' => services\OEmbeds::class,
      'relations' => services\Relations::class,
      'schemas' => services\Schemas::class,
      'structures' => services\definitions\StructureDefinitions::class,
      'translators' => services\Translators::class,
    ]);

    Craft::$app->view->registerTwigExtension(new Extension());

    helpers\listeners\Anchors::register();
    helpers\listeners\Frontend::register();
    helpers\listeners\Caches::register();
    helpers\listeners\Registry::register();
    helpers\listeners\YamlLoader::register();
  }

  /**
   * @inheritDoc
   * @throws Throwable
   */
  public function afterSaveSettings(): void {
    Craft::$app->cache->flush();
    FileHelper::clearDirectory(
      Craft::$app->getPath()->getCompiledTemplatesPath(false)
    );

    parent::afterSaveSettings();
  }


  // Protected methods
  // -----------------

  /**
   * @inheritdoc
   */
  protected function createSettingsModel(): Config {
    return new Config();
  }

  /**
   * @inheritDoc
   * @throws Throwable
   */
  protected function settingsHtml(): string {
    return Craft::$app->getView()->renderTemplate('contentfield/_config', [
      'config'      => $this->getSettings(),
      'translators' => $this->translators,
    ]);
  }


  // Static methods
  // --------------

  /**
   * @param string|null $value
   * @return string|null
   */
  static public function t(?string $value): ?string {
    return empty($value)
      ? $value
      : Craft::t(self::$TRANSLATION_CATEGORY, $value);
  }
}
