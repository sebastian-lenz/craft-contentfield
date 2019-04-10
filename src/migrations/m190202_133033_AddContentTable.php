<?php

namespace sebastianlenz\contentfield\migrations;

use sebastianlenz\contentfield\fields\ContentField;
use sebastianlenz\contentfield\records\ContentRecord;
use craft\db\Migration;
use craft\db\Table;

/**
 * m190202_133033_AddContentTable migration.
 */
class m190202_133033_AddContentTable extends Migration
{
  /**
   * @inheritdoc
   */
  public function safeUp() {
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

    $this->createIndex('contentfield_elementId_siteId_unq_idx', ContentRecord::TABLE, ['elementId', 'siteId'], true);
    $this->createIndex('contentfield_siteId_idx', ContentRecord::TABLE, ['siteId'], false);
    $this->createIndex('contentfield_fieldId_idx', ContentRecord::TABLE, ['fieldId'], false);

    $this->addForeignKey(null, ContentRecord::TABLE, ['elementId'], Table::ELEMENTS, ['id'], 'CASCADE', null);
    $this->addForeignKey(null, ContentRecord::TABLE, ['fieldId'], Table::FIELDS, ['id'], 'CASCADE', null);

    foreach (\Craft::$app->getFields()->getAllFields() as $field) {
      if (!($field instanceof ContentField)) {
        continue;
      }

      $columnName = 'field_' . $field->handle;
      $rows = (new \yii\db\Query())
        ->select(['elementId', 'siteId', $columnName])
        ->from(Table::CONTENT)
        ->where(['not', [$columnName => null]])
        ->all();

      foreach ($rows as $row) {
        $this->db->createCommand()->insert(ContentRecord::TABLE, [
          'elementId' => $row['elementId'],
          'siteId'    => $row['siteId'],
          'fieldId'   => $field->id,
          'content'   => $row[$columnName]
        ])->execute();
      }

      $this->dropColumn(Table::CONTENT, $columnName);
    }
  }

  /**
   * @inheritdoc
   */
  public function safeDown() {
    echo "m190202_133033_AddContentTable cannot be reverted.\n";
    return false;
  }
}
