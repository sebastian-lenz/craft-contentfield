<?php

namespace lenz\contentfield\migrations;

use craft\db\Migration;
use craft\helpers\Json;
use craft\records\Field;
use lenz\contentfield\fields\ContentField;

/**
 * m190611_213100_RefactorFieldSettings migration.
 */
class m190611_213100_RefactorFieldSettings extends Migration
{
  /**
   * @inheritdoc
   */
  public function safeUp() {
    $fields = Field::findAll(['type' => ContentField::class]);
    foreach ($fields as $field) {
      $settings = Json::decode($field->settings);
      if (!array_key_exists('rootTemplates', $settings)) {
        continue;
      }

      $settings['rootSchemas'] = $settings['rootTemplates'];
      unset($settings['rootTemplates']);

      $field->settings = Json::encode($settings);
      $field->save();
    }
  }

  /**
   * @inheritdoc
   */
  public function safeDown() {
    echo "m190611_213100_RefactorFieldSettings cannot be reverted.\n";
    return false;
  }
}
