<?php

/**
 * Represents the component for handling appointment bookings.
 */
class BookingManager {
  /**
   * Books an appointment using the given approved request and slot details.
   *
   * @param array $data Approved request and slot details.
   * @return void
   */
  public static function bookAppointment($data) {
    // Validate the user's given times
    $valid = self::validateAppointment($data);

    if ($valid) {
      try {
        $appointment_data = array();

        // Set parameters and values for each detail
        foreach (array_keys($data) as $detail) {
          $appointment_data[$detail] = array(
            'param' => ":$detail",
            'value' => $data[$detail],
          );
        }

        // Add unique ID to the appointment
        $appointment_data['id'] = array(
          'param' => ":id",
          'value' => uniqid('ap-', true),
        );

        // Insert record for the booked appointment
        $appointment_result = $GLOBALS['app']->getDB()->insert('appointment', $appointment_data);

        if ($appointment_result) {
          $GLOBALS['successes'][] = 'The appointment has been successfully booked.';
        } else {
          $GLOBALS['errors'][] = 'An unexpected error has occurred. Please check your input and try again.';
        }
      } catch (PDOException $e) {
        $GLOBALS['errors'][] = $e->getMessage();
      }
    } else {
      $GLOBALS['errors'][] = 'Sorry, your selections were in an incorrect format. Please check them and try again.';
    }
  }

  /**
   * Checks whether the approved request and slot details are in the correct format and not empty.
   *
   * @param array $data Collection of the approved request and slot details.
   * @return boolean Whether the approved request and slot details pass (true) or fail (false) validation.
   */
  public static function validateAppointment($data) {
    if (empty($data['request_id'])) {
      $GLOBALS['errors'][] = 'Please select an existing appointment booking request.';
    } elseif (empty($data['availability_id']) && $data['availability_id'] != null) {
      $GLOBALS['errors'][] = 'Please ensure the selected staff member is available for the selected slot.';
    } else {
      return true;
    }

    return false;
  }
}
