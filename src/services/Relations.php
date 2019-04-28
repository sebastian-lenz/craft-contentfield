<?php

namespace lenz\contentfield\services;

use lenz\contentfield\fields\ContentField;
use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use yii\base\Component;

/**
 * Relations service.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 3.0
 */
class Relations extends Component
{
  /**
   * Saves some relations for a field.
   *
   * @param ContentField $field
   * @param ElementInterface $source
   * @param array $targetIds
   * @throws \Throwable
   */
  public function saveRelations(ContentField $field, ElementInterface $source, array $targetIds)
  {
    /** @var Element $source */
    if (!is_array($targetIds)) {
      $targetIds = [];
    }

    // Prevent duplicate target IDs.
    $targetIds = array_unique($targetIds);

    $transaction = Craft::$app->getDb()->beginTransaction();

    try {
      // Delete the existing relations
      $oldRelationConditions = [
        'and',
        [
          'fieldId' => $field->id,
          'sourceId' => $source->id,
        ]
      ];

      if ($field->hasLocalizedRelations()) {
        $oldRelationConditions[] = [
          'or',
          ['sourceSiteId' => null],
          ['sourceSiteId' => $source->siteId]
        ];
      }

      Craft::$app->getDb()->createCommand()
        ->delete('{{%relations}}', $oldRelationConditions)
        ->execute();

      // Add the new ones
      if (!empty($targetIds)) {
        $values = [];

        if ($field->hasLocalizedRelations()) {
          $sourceSiteId = $source->siteId;
        } else {
          $sourceSiteId = null;
        }

        foreach ($targetIds as $sortOrder => $targetId) {
          $values[] = [
            $field->id,
            $source->id,
            $sourceSiteId,
            $targetId,
            $sortOrder + 1
          ];
        }

        $columns = [
          'fieldId',
          'sourceId',
          'sourceSiteId',
          'targetId',
          'sortOrder'
        ];
        Craft::$app->getDb()->createCommand()
          ->batchInsert('{{%relations}}', $columns, $values)
          ->execute();
      }

      $transaction->commit();
    } catch (\Throwable $e) {
      $transaction->rollBack();

      throw $e;
    }
  }
}
