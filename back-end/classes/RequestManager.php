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
        $request_id = uniqid('', true);

        // Separate details about the patient and their request themselves
        $request_data = array(
          'id' => array(
            'param' => ':id',
            'value' => $request_id,
          ),
          'reason' => array(
            'param' => ':reason',
            'value' => $data['appointment_reason'],
          ),
          'translation' => array(
            'param' => ':translation',
            'value' => $data['translation_choice'] === 'none' ? null : $data['translation_choice'],
          ),
          'preferred_staff' => array(
            'param' => ':preferred_staff',
            'value' => $data['staff_choice'],
          ),
          'patient_id' => array(
            'param' => ':patient_id',
            'value' => $data['patient_id'],
          ),
        );

        // Insert records for the patient's request
        $request_result = $GLOBALS['app']->getDB()->insert('request', $request_data);

        $slots_results = array();

        for ($i = 0; $i < count($data['slots']); $i += 1) {
          $slot_data = array(
            'id' => array(
              'param' => ':id',
              'value' => uniqid('', true),
            ),
            'request_id' => array(
              'param' => ':request_id',
              'value' => $request_id,
            ),
            'slot_id' => array(
              'param' => ':slot_id',
              'value' => $data['slots'][$i],
            ),
          );

          // Insert records for the patient's selected slots
          $slots_results[] = $GLOBALS['app']->getDB()->insert('request_slot', $slot_data);
        }

        // Check if any slot insertions failed
        $slot_result = !in_array(false, $slots_results, true);

        if ($request_result && $slot_result) {
          // Retrieve the ID of the patient's facility
          $facilityId = UserManager::getUserFacilityID($data['patient_id']);
        } else {
          $GLOBALS['errors'][] = 'An unexpected error has occurred. Please check your input and try again.';
        }
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
