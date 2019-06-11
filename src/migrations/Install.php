<?php

namespace lenz\contentfield\migrations;

use lenz\contentfield\records\ContentRecord;
use craft\db\Migration;
use craft\db\Table;

/**
 * Class Install
 */
class Install extends Migration
{
  /**
   * @inheritdoc
   */
  public function safeUp() {
    ContentRecord::createTable($this, [
      'model' => $this->longText(),
    ]);

    if (!$this->db->tableExists(ContentRecord::TABLE)) {
      $this->createTable(ContentRecord::TABLE, [
        'id'          => $this->primaryKey(),
        'elementId'   => $this->integer()->notNull(),
        'siteId'      => $this->integer()->notNull(),
        'fieldId'     => $this->integer()->notNull(),
        'dateCreated' => $this->dateTime()->notNull(),
        'dateUpdated' => $this->dateTime()->notNull(),
        'uid'         => $this->uid(),
        'content'     => $this->longText(),
      ]);

      $this->createIndex(null, ContentRecord::TABLE, ['elementId', 'siteId'], true);
      $this->createIndex(null, ContentRecord::TABLE, ['siteId'], false);
      $this->createIndex(null, ContentRecord::TABLE, ['fieldId'], false);

      $this->addForeignKey(null, ContentRecord::TABLE, ['elementId'], Table::ELEMENTS, ['id'], 'CASCADE', null);
      $this->addForeignKey(null, ContentRecord::TABLE, ['fieldId'], Table::FIELDS, ['id'], 'CASCADE', null);
    }
  }

  /**
   * @inheritdoc
   */
  public function safeDown() {
    return false;
  }
}
