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

        // Remove unneeded details for insertion
        unset($appointment_data['patient_id']);
        unset($appointment_data['contact_by_email']);
        unset($appointment_data['contact_by_text']);

        // Insert record for the booked appointment
        $appointment_result = $GLOBALS['app']->getDB()->insert('appointment', $appointment_data);

        if ($appointment_result) {
          // Retrieve the details of the patient's facility
          $facility_details = UserManager::getUserFacility($data['patient_id']);

          $GLOBALS['successes'][] = 'The appointment has been successfully booked.';

          // Define message to be sent via the user's contact preferences
          $message = 'Your requested appointment with ';
          $message .= isset($facility_details['name']) ? $facility_details['name'] : 'us';
          $message .= ' has been booked. Please log on to see the confirmed details.';

          if ($data['contact_by_email']) {
            UserManager::receiveEmail($data['patient_id'], $message);
          }
          if ($data['contact_by_text']) {
            UserManager::receiveSms($data['patient_id'], $message);
          }
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
