<?php

namespace lenz\contentfield\fields\content;

use craft\elements\db\ElementQuery;
use craft\errors\InvalidFieldException;
use craft\events\PopulateElementEvent;
use Exception;
use lenz\contentfield\helpers\ReferenceLoader;
use lenz\contentfield\models\Content;
use lenz\craft\utils\foreignField\ForeignFieldQueryExtension;

/**
 * Class QueryExtension
 */
class QueryExtension extends ForeignFieldQueryExtension
{
  /**
   * @var ReferenceLoader
   */
  private $_referenceLoader;


  /**
   * @return void
   */
  protected function attachEagerLoad() {
    parent::attachEagerLoad();

    $this->query->on(
      ElementQuery::EVENT_AFTER_POPULATE_ELEMENT,
      [$this, 'onAfterPopulateElement']
    );
  }

  /**
   * @param PopulateElementEvent $event
   * @throws Exception
   */
  public function onAfterPopulateElement(PopulateElementEvent $event) {
    try {
      $handle = $this->field->handle;
      $content = is_null($event->element) || is_null($handle)
        ? null
        : $event->element->getFieldValue($handle);
    } catch (InvalidFieldException $exception) {
      // This happens queries eager load fields that are present only
      // on a part of the query results, we can safely ignore it
      $content = null;
    }

    if ($content instanceof Content) {
      if (!isset($this->_referenceLoader)) {
        $this->_referenceLoader = new ReferenceLoader();
      }

      try {
        $content->setReferenceLoader($this->_referenceLoader);
      } catch (Exception $error) {
        unset($this->_referenceLoader);
      }
    }
  }
}
