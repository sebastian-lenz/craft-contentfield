<?php

namespace lenz\contentfield\migrations;

use Craft;
use lenz\contentfield\fields\ContentField;
use lenz\contentfield\records\ContentRecord;
use craft\db\Migration;
use craft\db\Table;
use yii\db\Query;

/**
 * m190202_133033_AddContentTable migration.
 */
class m190202_133033_AddContentTable extends Migration
{
  /**
   * @inheritdoc
   */
  public function safeUp() {
    ContentRecord::createTable($this);

    foreach (Craft::$app->getFields()->getAllFields() as $field) {
      if (!($field instanceof ContentField)) {
        continue;
      }

      $columnName = 'field_' . $field->handle;
      $rows = (new Query())
        ->select(['elementId', 'siteId', $columnName])
        ->from(Table::CONTENT)
        ->where(['not', [$columnName => null]])
        ->all();

      foreach ($rows as $row) {
        $this->db->createCommand()->insert(ContentRecord::tableName(), [
          'elementId' => $row['elementId'],
          'siteId'    => $row['siteId'],
          'fieldId'   => $field->id,
          'model'     => $row[$columnName]
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
