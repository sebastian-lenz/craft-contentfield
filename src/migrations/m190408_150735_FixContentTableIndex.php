<?php

namespace lenz\contentfield\migrations;

use craft\db\Migration;
use craft\db\Table;
use lenz\contentfield\records\ContentRecord;
use Throwable;

/**
 * m190408_150735_FixContentTableIndex migration.
 */
class m190408_150735_FixContentTableIndex extends Migration
{
  /**
   * @inheritdoc
   */
  public function safeUp() {
    $tableName = ContentRecord::tableName();

    try {
      $this->dropForeignKey('contentfield_elementId_fk', $tableName);
    } catch (Throwable $error) {
      // Ignore this error
    }

    try {
      $this->dropIndex('contentfield_elementId_siteId_unq_idx', $tableName);
    } catch (Throwable $error) {
      // Ignore this error
    }

    $this->createIndex(null, $tableName, ['elementId', 'siteId', 'fieldId'], true);
    $this->addForeignKey(null, $tableName, ['elementId'], Table::ELEMENTS, ['id'], 'CASCADE', null);
  }

  /**
   * @inheritdoc
   */
  public function safeDown() {
    echo "m190408_150735_fixContentTableIndex cannot be reverted.\n";
    return false;
  }
}
