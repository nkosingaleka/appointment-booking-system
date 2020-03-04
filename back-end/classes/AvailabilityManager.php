<?php

/**
 * Represents the component for handling medical staff availability for bookable time slots.
 */
class AvailabilityManager {
  /**
   * Retrieves all bookable slots for the current week.
   *
   * @return array Collection of bookable time slots.
   */
  public static function getSlots() {
    // Define conditions to be checked in query
    $current_week = 'WEEK(CURDATE(), 1)';

    $selections = array(
      'WEEK(start_time, 1)' => array(
        'comparison' => '=',
        'param' => $current_week,
        'value' => '',
        'after' => 'ORDER BY start_time DESC',
      ),
    );

    // Define columns to select
    $projections = array('start_time', 'end_time');

    // Retrieve slots for the current week
    return $GLOBALS['app']->getDB()->selectWhere('slot', $selections, $projections, false);
  }
}
