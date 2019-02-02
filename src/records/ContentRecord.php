<?php

namespace contentfield\records;

use craft\db\ActiveRecord;
use craft\db\SoftDeleteTrait;
use craft\db\Table;
use yii\db\ActiveQueryInterface;

/**
 * Class ContentRecord
 *
 * @property int $id
 * @property int $elementId
 * @property int $siteId
 * @property int $fieldId
 * @property string $content
 */
class ContentRecord extends ActiveRecord
{
  /**
   * The name of the table used to store this record.
   */
  const TABLE = '{{%contentfield}}';


  /**
   * @inheritdoc
   */
  public static function tableName(): string {
    return self::TABLE;
  }
}
