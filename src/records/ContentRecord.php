<?php

namespace lenz\contentfield\records;

use craft\db\Migration;
use craft\helpers\Json;
use lenz\craft\utils\foreignField\ForeignFieldRecord;

/**
 * Class ContentRecord
 *
 * @property string $model
 */
class ContentRecord extends ForeignFieldRecord
{
  /**
   * The length of our format header.
   * All FORMAT_* constants must be of this length.
   */
  const FORMAT_LENGTH = 3;

  /**
   * Defines the known compression formats
   */
  const FORMAT_GZ_BASE64 = 'gz:';

  /**
   * Stores all known compression formats as an array.
   */
  const FORMATS = [
    self::FORMAT_GZ_BASE64,
  ];


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
      'model' => $migration->longText(),
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
   * Decodes a model when retrieving it from the database. Takes care
   * for JSON encoding and compression.
   *
   * @internal
   * @param string $value
   * @return array
   */
  static function decodeModel(string $value) {
    $format = substr($value, 0, self::FORMAT_LENGTH);
    if (in_array($format, self::FORMATS)) {
      $value = substr($value, self::FORMAT_LENGTH);

      if ($format == self::FORMAT_GZ_BASE64) {
        $value = gzuncompress(base64_decode($value));
      }
    }

    return Json::decode($value, true);
  }

  /**
   * Encodes a model before storing it to the database. Opposite
   * operation to `ContentRecord::decodeModel`.
   *
   * @internal
   * @param array $model
   * @param string|null $compression
   * @return string
   */
  static function encodeModel(array $model, string $compression = null) {
    $data = Json::encode($model);

    if ($compression == self::FORMAT_GZ_BASE64) {
      $compressed = gzcompress($data);
      if ($compressed !== false) {
        $data = self::FORMAT_GZ_BASE64 . base64_encode($compressed);
      }
    }

    return $data;
  }

  /**
   * Returns the best available compression method.
   *
   * @internal
   * @return string|null
   */
  static function getAvailableCompression() {
    if (function_exists('gzcompress')) {
      return ContentRecord::FORMAT_GZ_BASE64;
    }

    return null;
  }

  /**
   * Retrieve the compression method of the given raw record
   * model value.
   *
   * @internal
   * @param string $value
   * @return string|null
   */
  static function getCompression(string $value) {
    $format = substr($value, 0, self::FORMAT_LENGTH);
    return in_array($format, self::FORMATS)
      ? $format
      : null;
  }
}
