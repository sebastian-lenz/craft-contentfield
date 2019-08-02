<?php

namespace lenz\contentfield\helpers;

use Craft;
use craft\queue\BaseJob;
use Exception;
use lenz\contentfield\fields\ContentField;
use lenz\contentfield\Plugin;
use lenz\contentfield\records\ContentRecord;

/**
 * Class CompressRecordsJob
 *
 * Recompresses all content records of a field after the compression
 * settings of the field have been changed.
 */
class CompressRecordsJob extends BaseJob
{
  /**
   * The id of the field whose content record should be recompressed.
   *
   * @var int
   */
  public $fieldId;

  /**
   * The ids of the content records that should recompressed.
   *
   * @var int[]
   */
  public $recordIds;


  /**
   * @inheritdoc
   * @throws Exception
   */
  public function execute($queue) {
    $field = Craft::$app->getFields()->getFieldById($this->fieldId);
    if (!($field instanceof ContentField)) {
      throw new Exception('Invalid field given, must be an instance of ContentField.');
    }

    $records = ContentRecord::findAll(['id' => $this->recordIds]);
    $count   = count($this->recordIds);
    $index   = 0;

    foreach ($records as $record) {
      $this->setProgress($queue, $index++ / $count);
      if (is_null($record->model) || is_null($record->elementId)) {
        continue;
      }

      $element = Craft::$app
        ->getElements()
        ->getElementById($record->elementId, null, $record->siteId);

      $actual = ContentRecord::getCompression($record->model);
      $target = $field->shouldCompress($element);
      if ($actual == $target) {
        continue;
      }

      $record->model = ContentRecord::encodeModel(
        ContentRecord::decodeModel($record->model),
        $target
      );

      $record->save();
    }
  }


  // Protected methods
  // -----------------

  /**
   * @inheritDoc
   */
  protected function defaultDescription() {
    return Plugin::t('Compress content data');
  }
}
