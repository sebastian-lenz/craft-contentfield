<?php

namespace lenz\contentfield\migrations;

use craft\db\Migration;
use lenz\contentfield\records\ContentRecord;

/**
 * m190604_193721_RenameContentColumn migration.
 * @noinspection PhpUnused
 */
class m190604_193721_RenameContentColumn extends Migration
{
  /**
   * @inheritdoc
   */
  public function safeUp() {
    $this->renameColumn(ContentRecord::tableName(), 'content', 'model');
  }

  /**
   * @inheritdoc
   */
  public function safeDown() {
    echo "m190604_193721_RenameContentColumn cannot be reverted.\n";
    return false;
  }
}
