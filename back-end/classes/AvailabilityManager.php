<?php

/**
 * Represents the component for handling medical staff availability for bookable time slots.
 */
class AvailabilityManager {
  /**
   * Retrieves all bookable slots for the current date.
   *
   * @return array Collection of bookable time slots.
   */
  public static function getSlots() {
    // Define the available booking period (3 weeks from current date)
    $period = 'WEEK(CURDATE(), 1) + 3';
    
    // Define conditions to be checked in query
    $selections = array(
      'WEEK(start_time, 1)' => array(
        'comparison' => '<=',
        'param' => $period,
        'value' => '',
        'after' => 'ORDER BY start_time DESC',
      ),
    );

    // Define columns to select
    $projections = array('id', 'start_time', 'end_time');

    // Retrieve slots for the current week
    return $GLOBALS['app']->getDB()->selectWhere('slot', $selections, $projections, false);
  }
}
