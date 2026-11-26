<?php

namespace lenz\contentfield\helpers\listeners;

use Craft;
use craft\events\ConfigEvent;
use craft\services\ProjectConfig;
use lenz\contentfield\helpers\ckeditor\ConfigExporter;
use Throwable;
use yii\base\Event;

/**
 * Class CKEditorConfigs
 *
 * craftcms/ckeditor 5 removes the shared CKEditor configs from the project
 * config and only moves them into the settings of native fields. Content
 * fields reference these configs too, so we export them to
 * `config/content/cke` the moment they are removed.
 */
class CKEditorConfigs
{
  /**
   * @param ConfigEvent $event
   */
  static public function onRemoveItem(ConfigEvent $event): void {
    if (!str_starts_with($event->path, 'ckeditor')) {
      return;
    }

    $configs = ConfigExporter::extractConfigs($event->path, $event->oldValue);
    if (empty($configs)) {
      return;
    }

    try {
      $exported = ConfigExporter::export($configs);
    } catch (Throwable $error) {
      // Never break the running migration or project config sync
      Craft::error(sprintf(
        "Could not export the CKEditor configs to config/content/cke: %s\n%s",
        $error->getMessage(),
        json_encode($configs)
      ), __METHOD__);
      return;
    }

    foreach ($exported as $uid => $name) {
      $message = "Exported CKEditor config $uid to config/content/cke/$name.yml";
      Craft::info($message, __METHOD__);

      if (Craft::$app->getRequest()->getIsConsoleRequest()) {
        echo "    > $message\n";
      }
    }
  }

  /**
   * @return void
   */
  static public function register(): void {
    Event::on(
      ProjectConfig::class,
      ProjectConfig::EVENT_REMOVE_ITEM,
      [self::class, 'onRemoveItem']
    );
  }
}
