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

  /**
   * Adds opportunities for patients to have an appointment booked with a particular medical staff member.
   *
   * @param array $data The specified times for which the medical staff member will be available to attend appointments.
   * @return void
   */
  public static function addAvailability($data) {
    // Validate the user's given times
    $valid = self::validateAvailability($data);

    if ($valid) {
      try {
        // Define conditions for any existing slots to be checked in query
        $existing_slot_selections = array(
          'start_time' => array(
            'comparison' => '=',
            'param' => ':start_time',
            'value' => $data['start_time'],
            'after' => 'AND',
          ),
          'end_time' => array(
            'comparison' => '=',
            'param' => ':end_time',
            'value' => $data['end_time'],
          ),
        );

        // Check if the slot already exists
        $existing_slot_result = $GLOBALS['app']->getDB()->selectOneWhere('slot', $existing_slot_selections, ['id']);

        // Define data for the new availability to be added
        $availability_data = array(
          'id' => array(
            'param' => ':id',
            'value' => uniqid('', true),
          ),
          'staff_id' => array(
            'param' => ':staff_id',
            'value' => $_SESSION['user']->id,
          ),
        );

        // If the time slot already exists
        if (isset($existing_slot_result['id'])) {
          // Use the existing slot's ID
          $availability_data['slot_id'] = array(
            'param' => ':slot_id',
            'value' => $existing_slot_result['id'],
          );
        } else {
          // Generate a unique ID for the new slot
          $slot_id = uniqid('', true);

          // Define data for the new slot to be added
          $slot_data = array(
            'id' => array(
              'param' => ':slot_data',
              'value' => $slot_id,
            ),
            'start_time' => array(
              'param' => ':start_time',
              'value' => $data['start_time'],
            ),
            'end_time' => array(
              'param' => ':end_time',
              'value' => $data['end_time'],
            ),
          );

          // Insert a record for a new slot to cater for the user's available times
          $new_slot_result = $GLOBALS['app']->getDB()->insert('slot', $slot_data);

          if ($new_slot_result) {
            echo 'Slot added.';
          } else {
            $GLOBALS['errors'][] = 'An unexpected error has occurred. Please check your input and try again.';
          }

          // Use the unique ID for the new slot
          $availability_data['slot_id'] = array(
            'param' => ':slot_id',
            'value' => $slot_id,
          );
        }

        // Insert a record for the user's available times
        $availability_result = $GLOBALS['app']->getDB()->insert('availability', $availability_data);

        if ($availability_result) {
          echo 'Availability added.';
        } else {
          $GLOBALS['errors'][] = 'An unexpected error has occurred. Please check your input and try again.';
        }

        // Check if availability already exists
      } catch (PDOException $e) {
        $GLOBALS['errors'][] = $e->getMessage();
      }
    } else {
      $GLOBALS['errors'][] = 'Sorry, your times were in an incorrect format. Please check your input and try again.';
    }
  }

  /**
   * Checks whether the medical staff member's specified times for which to accept appointments are in the correct format.
   *
   * @param string $data The specified times for which the medical staff member will be available to attend appointments.
   * @return boolean Whether the medical staff member's available times pass (true) or fail (false) validation.
   */
  private static function validateAvailability($data) {
    if (empty($data['start_time'])) {
      $GLOBALS['errors'][] = 'Please enter a valid start time.';
    } else if (empty($data['end_time'])) {
      $GLOBALS['errors'][] = 'Please enter a valid end time.';
    } else {
      return true;
    }

    return false;
  }
}
