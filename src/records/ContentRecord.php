<?php

namespace lenz\contentfield\records;

use craft\db\Migration;
use lenz\craft\utils\foreignField\ForeignFieldRecord;

/**
 * Class ContentRecord
 * @property string $model
 */
class ContentRecord extends ForeignFieldRecord
{
  /**
   * @param Migration $migration
   * @param array $columns
   */
  public static function createTable(Migration $migration, array $columns = []) {
    return parent::createTable($migration, $columns + [
      'model' => $migration->longText()
    ]);
  }

  /**
   * @inheritDoc
   */
  public static function tableName() {
    return '{{%lenz_contentfield}}';
  }
}
