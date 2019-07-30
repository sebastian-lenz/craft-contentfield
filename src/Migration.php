<?php

namespace lenz\contentfield;

use Craft;
use craft\base\Field;
use craft\db\Migration as MigrationBase;
use craft\helpers\StringHelper;
use Exception;
use lenz\contentfield\fields\ContentField;
use lenz\contentfield\models\migration\Instance;
use lenz\contentfield\records\ContentRecord;

/**
 * Class Migration
 *
 * A base class for migrations altering content fields.
 */
abstract class Migration extends MigrationBase
{
  /**
   * @inheritDoc
   * @throws Exception
   */
  public function safeUp() {
    $this->migrateRecords(
      $this->findAffectedRecords()
    );
  }

  /**
   * @inheritDoc
   */
  public function safeDown() {
    echo "This migration cannot be reverted.\n";
    return false;
  }


  // Protected methods
  // -----------------

  /**
   * Retrieve all content records that should be migrated.
   *
   * @return ContentRecord[]
   */
  protected function findAffectedRecords() {
    $query = ContentRecord::find();

    $affectedFields = $this->getAffectedFields();
    if (!is_null($affectedFields)) {
      $affectedFields = self::toFieldIds($affectedFields);
      if (count($affectedFields) > 0) {
        $query->andWhere(['fieldId' => $affectedFields]);
      }
    }

    return $query->all();
  }

  /**
   * Returns the handles, ids or uids of the fields affected by this
   * migration. Return null to migrate all fields.
   *
   * @return string|string[]|null
   */
  protected function getAffectedFields() {
    return null;
  }

  /**
   * Migrates the given content field value.
   *
   * @param ContentField $field
   * @param Instance $instance
   * @return false|void
   */
  abstract protected function migrate(ContentField $field, Instance $instance);

  /**
   * Invokes the migrate callback for all given content records.
   *
   * @param ContentRecord[] $records
   * @throws Exception
   */
  protected function migrateRecords($records) {
    $fields = Craft::$app->getFields();

    foreach ($records as $record) {
      if (is_null($record->model)) {
        continue;
      }

      $isCompressed = ContentRecord::isCompressed($record->model);
      $field = $fields->getFieldById($record->fieldId);
      $model = new Instance(
        ContentRecord::decodeModel($record->model)
      );

      if (!($field instanceof ContentField)) {
        throw new Exception(sprintf(
          'The content record with the id %s refers to the field with the id %s, but this field is not a content field.',
          $record->id, $record->fieldId
        ));
      }

      if ($this->migrate($field, $model) === false) {
        continue;
      }

      $record->model = ContentRecord::encodeModel(
        $model->getSerializedValue(),
        $isCompressed
      );

      $record->save();
    }
  }

  // Static methods
  // --------------

  /**
   * @param string|int|array $values
   * @return int[]
   */
  static function toFieldIds($values) {
    $fields = Craft::$app->getFields();
    $values = is_array($values) ? $values : [$values];

    return array_filter(
      array_map(function($value) use ($fields) {
        if (is_numeric($value)) {
          $field = $fields->getFieldById($value);
        } elseif (StringHelper::isUUID($value)) {
          $field = $fields->getFieldByUid($value);
        } else {
          $field = $fields->getFieldByHandle($value);
        }

        if (!($field instanceof Field)) {
          throw new Exception(sprintf('Invalid field identifier `%s`.', $value));
        }

        return $field->id;
      }, $values)
    );
  }
}
