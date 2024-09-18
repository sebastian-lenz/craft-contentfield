<?php

namespace lenz\contentfield\migrations;

use Craft;
use craft\db\Migration;
use craft\db\Table;
use lenz\contentfield\fields\ContentField;
use lenz\contentfield\records\ContentRecord;
use yii\db\Exception;
use yii\db\Query;

/**
 * m190202_133033_AddContentTable migration.
 * @noinspection PhpUnused
 */
class m190202_133033_AddContentTable extends Migration
{
  /**
   * @inheritdoc
   * @throws Exception
   */
  public function safeUp() {
    $this->update(
      Table::FIELDS,
      ['type' => 'lenz\\contentfield\\fields\\ContentField'],
      ['type' => 'contentfield\\fields\\ContentField']
    );

    $table = ContentRecord::tableName();
    $this->createTable($table, [
      'id'          => $this->primaryKey(),
      'elementId'   => $this->integer()->notNull(),
      'siteId'      => $this->integer()->notNull(),
      'fieldId'     => $this->integer()->notNull(),
      'dateCreated' => $this->dateTime()->notNull(),
      'dateUpdated' => $this->dateTime()->notNull(),
      'uid'         => $this->uid(),
      'content'     => $this->longText(),
    ]);

    $this->createIndex('contentfield_elementId_siteId_unq_idx', $table, ['elementId', 'siteId'], true);
    $this->createIndex('contentfield_siteId_idx', $table, ['siteId']);
    $this->createIndex('contentfield_fieldId_idx', $table, ['fieldId']);
    $this->addForeignKey('contentfield_elementId_fk', $table, ['elementId'], Table::ELEMENTS, ['id'], 'CASCADE');
    $this->addForeignKey('contentfield_fieldId_fk', $table, ['fieldId'], Table::FIELDS, ['id'], 'CASCADE');

    $fields = Craft::$app->getFields();
    $fields->refreshFields();
    foreach ($fields->getAllFields() as $field) {
      if (!($field instanceof ContentField)) {
        continue;
      }

      $columnName = 'field_' . $field->handle;
      $rows = (new Query())
        ->select(['elementId', 'siteId', $columnName])
        ->from('{{%content}}')
        ->where(['not', [$columnName => null]])
        ->all();

      foreach ($rows as $row) {
        $this->db->createCommand()->insert($table, [
          'elementId' => $row['elementId'],
          'siteId'    => $row['siteId'],
          'fieldId'   => $field->id,
          'content'   => $row[$columnName]
        ])->execute();
      }

      $this->dropColumn('{{%content}}', $columnName);
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
