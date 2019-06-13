<?php

namespace lenz\contentfield\migrations;

use craft\db\Migration;
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
      if (!array_key_exists('', $field->settings)) {
        continue;
      }

      $field->settings['rootSchemas'] = $field->settings['rootTemplates'];
      unset($field->settings['rootTemplates']);
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
