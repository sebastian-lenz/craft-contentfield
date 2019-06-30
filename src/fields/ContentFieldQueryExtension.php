<?php

namespace lenz\contentfield\fields;

use craft\elements\db\ElementQuery;
use craft\events\PopulateElementEvent;
use lenz\contentfield\models\Content;
use lenz\contentfield\utilities\ReferenceLoader;
use lenz\craft\utils\foreignField\ForeignFieldQueryExtension;

/**
 * Class ContentFieldQueryExtension
 */
class ContentFieldQueryExtension extends ForeignFieldQueryExtension
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
   * @throws \Exception
   */
  public function onAfterPopulateElement(PopulateElementEvent $event) {
    $content = is_null($event->element)
      ? null
      : $event->element->getFieldValue($this->field->handle);

    if ($content instanceof Content) {
      if (!isset($this->_referenceLoader)) {
        $this->_referenceLoader = new ReferenceLoader();
      }

      try {
        $content->setReferenceLoader($this->_referenceLoader);
      } catch (\Exception $error) {
        unset($this->_referenceLoader);
      }
    }
  }
}
