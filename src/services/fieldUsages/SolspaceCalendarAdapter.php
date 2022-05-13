<?php

namespace lenz\contentfield\services\fieldUsages;

use craft\base\ElementInterface;
use craft\models\FieldLayout;
use craft\records\FieldLayoutField;
use Solspace\Calendar\Calendar;
use Solspace\Calendar\Elements\Event;
use Solspace\Calendar\Models\CalendarModel;

/**
 * Class SolspaceCalendarAdapter
 * @deprecated
 */
class SolspaceCalendarAdapter extends AbstractAdapter
{
  const CALENDAR_UID = 'solspace-calendar';


  /**
   * @inheritDoc
   */
  public function createUsages(Usage $scope, FieldLayout $layout, FieldLayoutField $layoutField): void {
    if ($layout->type == Event::class) {
      $calendar = $this->getCalendarByLayoutId($layout->id);
      if (is_null($calendar)) {
        return;
      }

      $scope->findOrCreate([
        'name' => 'Calendars',
        'type' => 'solspace-calendars',
        'uid'  => 'solspace-calendars',
      ])->findOrCreate([
        'name' => $calendar->name,
        'type' => 'solspace-calendar',
        'uid'  => 'solspace-calendar-' . $calendar->id,
      ]);
    }
  }

  /**
   * @inheritDoc
   */
  public function toUids(ElementInterface $element = null): ?array {
    if ($element instanceof Event) {
      return [
        'solspace-calendar-' . $element->calendarId,
        'solspace-calendars',
      ];
    }

    return null;
  }


  // Protected methods
  // -----------------

  /**
   * @param int $layoutId
   * @return CalendarModel|null
   */
  protected function getCalendarByLayoutId($layoutId): ?CalendarModel {
    $calendars = Calendar::getInstance()
      ->calendars
      ->getAllCalendars();

    foreach ($calendars as $calendar) {
      if ($calendar->fieldLayoutId == $layoutId) {
        return $calendar;
      }
    }

    return null;
  }
}
