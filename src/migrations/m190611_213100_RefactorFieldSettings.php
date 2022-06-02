<?php

namespace lenz\contentfield\migrations;

use craft\db\Migration;
use craft\records\Field;
use lenz\contentfield\fields\ContentField;

/**
 * m190611_213100_RefactorFieldSettings migration.
 * @noinspection PhpUnused
 */
class m190611_213100_RefactorFieldSettings extends Migration
{
  /**
   * @inheritdoc
   */
  public function safeUp() {
    $fields = Field::findAll(['type' => ContentField::class]);
    foreach ($fields as $field) {
      $settings = $field->settings;
      if (
        !is_array($settings) ||
        !array_key_exists('rootTemplates', $settings)
      ) {
        continue;
      }

      $settings['rootSchemas'] = $settings['rootTemplates'];
      unset($settings['rootTemplates']);

      $field->settings = $settings;
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
