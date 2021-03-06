<?php

/**
 * Class for the AvailabilityManager component.
 *
 * @category Core Component
 */

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
    $projections = array('id', 'start_time', 'end_time', 'reserved');

    try {
      // Retrieve slots for the current week
      return $GLOBALS['app']->getDB()->selectWhere('slot', $selections, $projections, false);
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
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
        // Convert to datetimes for comparison
        $start_datetime = new DateTime($data['start_time']);
        $end_datetime = new DateTime($data['end_time']);

        // Extract differences between the two timestamps
        $diff = $start_datetime->diff($end_datetime);

        // Extract difference in minutes only
        $minute_diff = $diff->days * 24 * 60;
        $minute_diff += $diff->h * 60;
        $minute_diff += $diff->i;

        // Calculate number of slots to be reserved
        $reserved = round($minute_diff * RESERVED_SLOTS / 10);

        // Check if the time difference is enough for slots to be added
        if ($minute_diff >= MIN_SLOTS * SLOT_LENGTH) {
          // Add slots between the start and end times
          for ($i = 0; $i < $minute_diff; $i += SLOT_LENGTH) {
            // Find intermediate start times
            $start_time = date(DATE_FORMAT, strtotime("+$i minutes", strtotime($data['start_time'])));
            $next_start_time = date(DATE_FORMAT, strtotime("+" . SLOT_LENGTH . "minutes", strtotime($start_time)));

            $end_time = $data['end_time'];

            // Set new intermediate end times if before the final end time
            if ($next_start_time <= $data['end_time']) {
              $end_time = $next_start_time;
            }

            // Define conditions for any existing slots to be checked in query
            $existing_slot_selections = array(
              'start_time' => array(
                'comparison' => '=',
                'param' => ':start_time',
                'value' => $start_time,
                'after' => 'AND',
              ),
              'end_time' => array(
                'comparison' => '=',
                'param' => ':end_time',
                'value' => $end_time,
              ),
            );

            // Check if the slot already exists
            $existing_slot_result = $GLOBALS['app']->getDB()->selectOneWhere('slot', $existing_slot_selections, ['id']);

            // Define data for the new availability to be added
            $availability_data = array(
              'id' => array(
                'param' => ':id',
                'value' => uniqid('av-', true),
              ),
              'staff_id' => array(
                'param' => ':staff_id',
                'value' => $_SESSION['user']->id,
              ),
            );

            // If the time slot already exists
            if (isset($existing_slot_result['id'])) {
              // Use the existing slot's ID
              $slot_id = $existing_slot_result['id'];
            } else {
              // Generate a unique ID for the new slot
              $slot_id = uniqid('sl-', true);

              // Define data for the new slot to be added
              $slot_data = array(
                'id' => array(
                  'param' => ':slot_data',
                  'value' => $slot_id,
                ),
                'start_time' => array(
                  'param' => ':start_time',
                  'value' => $start_time,
                ),
                'end_time' => array(
                  'param' => ':end_time',
                  'value' => $end_time,
                ),
              );

              // Reserve the correct number of slots
              if ($reserved >= ($i + SLOT_LENGTH) / 10) {
                $slot_data['reserved'] = array(
                  'param' => ':reserved',
                  'value' => true,
                );
              } else {
                $slot_data['reserved'] = array(
                  'param' => ':reserved',
                  'value' => false,
                );
              }

              // Insert a record for a new slot to cater for the user's available times
              $new_slot_result = $GLOBALS['app']->getDB()->insert('slot', $slot_data);

              if ($new_slot_result) {
                $success_msg = 'New slots have been successfully added.';

                if (!in_array($success_msg, $GLOBALS['successes'])) {
                  $GLOBALS['successes'][] = $success_msg;
                }
              } else {
                $GLOBALS['errors'][] = 'An unexpected error has occurred. Please check your input and try again.';
              }
            }

            // Use the unique ID for the new slot
            $availability_data['slot_id'] = array(
              'param' => ':slot_id',
              'value' => $slot_id,
            );

            // Define conditions for any existing availability to be checked in query
            $existing_availability_selections = array(
              'slot_id' => array(
                'comparison' => '=',
                'param' => ':slot_id',
                'value' => $availability_data['slot_id']['value'],
              ),
            );

            // Check if availability has already been added
            $existing_availability_result = $GLOBALS['app']->getDB()->selectOneWhere('availability', $existing_availability_selections, ['id']);

            if (!isset($existing_availability_result['id'])) {
              // Insert a record for the user's available times
              $availability_result = $GLOBALS['app']->getDB()->insert('availability', $availability_data);

              if ($availability_result) {
                $success_msg = 'Your availability has been successfully added.';

                if (!in_array($success_msg, $GLOBALS['successes'])) {
                  $GLOBALS['successes'][] = $success_msg;
                }
              } else {
                $GLOBALS['errors'][] = 'An unexpected error has occurred. Please check your input and try again.';
              }
            } else {
              $error_msg = 'Sorry, you have already added your availability for the specified times.';

              if (!in_array($error_msg, $GLOBALS['errors'])) {
                $GLOBALS['errors'][] = $error_msg;
              }
            }
          }
        } else {
          $GLOBALS['errors'][] = 'Sorry, you must allow time for ' . MIN_SLOTS . ' or more slots for at least 10% to be reserved for emergency appointments.';
        }
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
    $today = date(DATE_FORMAT);

    if (empty($data['start_time'])) {
      $GLOBALS['errors'][] = 'Please enter a valid start time.';
    } else if (empty($data['end_time'])) {
      $GLOBALS['errors'][] = 'Please enter a valid end time.';
    } else if ($data['end_time'] <= $data['start_time']) {
      $GLOBALS['errors'][] = 'Please enter an end time after the start time.';
    } else if (($data['end_time'] <= $today) || ($data['start_time'] < $today)) {
      $GLOBALS['errors'][] = 'Please do not enter start and end times in the past.';
    } else {
      return true;
    }

    return false;
  }

  /**
   * Retrieves the availability ID for a given slot and medical staff member.
   *
   * @param string $slotId ID of the selected slot.
   * @param string $staffId ID of the selected medical staff member.
   * @return array
   */
  public static function getAvailability($slotId, $staffId) {
    // Define availability conditions to be checked in query
    $selections = array(
      'slot_id' => array(
        'comparison' => '=',
        'param' => ':slot_id',
        'value' => $slotId,
        'after' => 'AND',
      ),
      'staff_id' => array(
        'comparison' => '=',
        'param' => ':staff_id',
        'value' => $staffId,
      ),
    );

    try {
      // Retrieve availability ID
      return $GLOBALS['app']->getDB()->selectOneWhere('availability', $selections, ['id'])['id'];
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }
}
