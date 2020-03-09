<?php

/**
 * Represents the component for handling patients' appointment booking requests.
 */
class RequestManager {
  /**
   * Sends an appointment booking request using the details provided by the patient.
   *
   * @param array $data Details about the appointment booking request.
   * @return void
   */
  public static function makeRequest($data) {
    // Validate the appointment booking request details
    $valid = self::validateRequest($data);

    if ($valid) {
      try {
        echo "passed validation";
      } catch (PDOException $e) {
        $GLOBALS['errors'][] = $e->getMessage();
      }
    } else {
      $GLOBALS['errors'][] = 'Sorry, your details were in an incorrect format. Please check your input and try again.';
    }
  }

  /**
   * Checks whether the patient's appointment booking request details are in the expected format.
   *
   * @param array $data Details about the appointment booking request.
   * @return boolean Whether the patient's appointment booking request details pass (true) or fail (false) validation.
   */
  private static function validateRequest($data) {
    if (empty($data['staff_choice'])) {
      $GLOBALS['errors'][] = 'Please select a staff member.';
    } else if (empty($data['slots'])) {
      $GLOBALS['errors'][] = 'Please select at least one time slot.';
    } else {
      return true;
    }

    return false;
  }
}
