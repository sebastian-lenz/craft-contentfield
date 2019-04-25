<?php

namespace lenz\contentfield\migrations;

use craft\db\Migration;
use craft\db\Table;
use lenz\contentfield\records\ContentRecord;

/**
 * m190408_150735_fixContentTableIndex migration.
 */
class m190408_150735_fixContentTableIndex extends Migration
{
  /**
   * @inheritdoc
   */
  public function safeUp() {
    try {
      $this->dropForeignKey('contentfield_elementId_fk', ContentRecord::TABLE);
    } catch (\Throwable $error) {}
    
    try {
      $this->dropIndex('contentfield_elementId_siteId_unq_idx', ContentRecord::TABLE);
    } catch (\Throwable $error) {}

    $this->createIndex(null, ContentRecord::TABLE, ['elementId', 'siteId', 'fieldId'], true);
    $this->addForeignKey(null, ContentRecord::TABLE, ['elementId'], Table::ELEMENTS, ['id'], 'CASCADE', null);
  }

  /**
   * @inheritdoc
   */
  public function safeDown() {
    echo "m190408_150735_fixContentTableIndex cannot be reverted.\n";
    return false;
  }
}
