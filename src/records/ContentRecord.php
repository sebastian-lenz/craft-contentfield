<?php

namespace lenz\contentfield\records;

use Craft;
use craft\db\Migration;
use craft\helpers\Json;
use lenz\craft\utils\foreignField\ForeignFieldRecord;

/**
 * Class ContentRecord
 * @property string $model
 */
class ContentRecord extends ForeignFieldRecord
{
  /**
   * @inheritDoc
   */
  public function attributes() {
    return [
      'id',
      'elementId',
      'siteId',
      'fieldId',
      'dateCreated',
      'dateUpdated',
      'uid',
      'model'
    ];
  }

  /**
   * @inheritDoc
   */
  public static function createTable(Migration $migration, array $columns = []) {
    return parent::createTable($migration, $columns + [
      'model' => self::getBinaryColumnType()
    ]);
  }

  /**
   * @inheritDoc
   */
  public static function tableName() {
    return '{{%lenz_contentfield}}';
  }
  
  
  // Static methods
  // --------------

  /**
   * @param string $value
   * @return array
   */
  static function decodeModel(string $value) {
    if (self::isCompressed($value)) {
      $value = gzdecode($value);
    }

    return Json::decode($value, true);
  }

  /**
   * @param array $model
   * @param bool $useCompression
   * @return string
   */
  static function encodeModel(array $model, bool $useCompression = false) {
    $data = Json::encode($model);

    if ($useCompression) {
      $compressed = gzencode($data);
      if ($compressed !== false) {
        $data = $compressed;
      }
    }

    return $data;
  }

  /**
   * @return string
   */
  static function getBinaryColumnType() {
    return Craft::$app->getDb()->getIsMysql()
      ? 'mediumblob'
      : 'bytea';
  }

  /**
   * @param string $value
   * @return bool
   */
  static function isCompressed(string $value) {
    return ord($value{0}) == 31 && ord($value{1}) == 139;
  }
}
