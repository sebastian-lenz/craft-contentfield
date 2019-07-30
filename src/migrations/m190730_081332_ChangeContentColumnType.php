<?php

namespace lenz\contentfield\migrations;

use craft\db\Migration;
use lenz\contentfield\records\ContentRecord;

/**
 * m190730_081332_ChangeContentColumnType migration.
 */
class m190730_081332_ChangeContentColumnType extends Migration
{
  /**
   * @inheritdoc
   */
  public function safeUp() {
    $this->alterColumn(ContentRecord::tableName(), 'model', ContentRecord::getBinaryColumnType());
  }

  /**
   * @inheritdoc
   */
  public function safeDown() {
    echo "m190730_081332_ChangeContentColumnType cannot be reverted.\n";
    return false;
  }
}
