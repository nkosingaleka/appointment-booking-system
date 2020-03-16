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
          // Retrieve the details of the patient's facility
          $facility_details = UserManager::getUserFacility($data['patient_id']);

          // Define message to be sent via the user's contact preferences
          $message = "Thank you for requesting an appointment with ";
          $message .= isset($facility_details['name']) ? $facility_details['name'] : 'us';
          $message .= ". You will be contacted as soon as possible.";

          if ($_SESSION['user']->contact_by_email) {
            UserManager::receiveEmail($data['patient_id'], $message);
          }
          if ($_SESSION['user']->contact_by_text) {
            UserManager::receiveSms($data['patient_id'], $message);
          }
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
    } elseif (empty($data['translation_choice'])) {
      $GLOBALS['errors'][] = 'Please select a translation option.';
    } elseif (empty($data['slots'])) {
      $GLOBALS['errors'][] = 'Please select at least one time slot.';
    } else {
      return true;
    }

    return false;
  }

  /**
   * Retrieves all the appointment booking requests made by a patient, referencing their account ID.
   *
   * @param string $patientId Account ID of the patient for which to display appointment booking requests.
   * @return array $requests Appointment Booking Requests made by the patient.
   */
  public static function getOwnRequests($patientId) {
    // Define JOIN tables
    $join_tables = array('language', 'request_slot', 'slot', 'patient', 'staff');

    // Define JOIN conditions
    $join_conditions = array(
      'language.id = translation',
      'request_slot.request_id = request.id',
      'slot.id = slot_id',
      'patient.id = patient_id',
      'staff.id = preferred_staff',
    );

    // Define conditions to be checked in query
    $selections = array(
      'patient_id' => array(
        'comparison' => '=',
        'param' => ':patient_id',
        'value' => $patientId,
      ),
    );

    // Define columns to select
    $projections = array('reason',
      'name AS translation',
      'staff.title',
      'staff.forename',
      'staff.surname',
      "GROUP_CONCAT(start_time, '_', end_time ORDER BY start_time) as 'slots'");

    try {
      // Retrieve all requests made by the patient
      $requests = $GLOBALS['app']->getDB()->selectJoinWhere('request', $join_tables, $join_conditions, $selections, $projections);

      for ($i = 0; $i < count($requests); $i += 1) {
        // Define full staff member name and a list of slots
        $requests[$i]['staff'] = "{$requests[$i]['title']} {$requests[$i]['forename']} {$requests[$i]['surname']}";
        $requests[$i]['slots'] = explode(',', $requests[$i]['slots']);

        for ($j = 0; $j < count($requests[$i]['slots']); $j += 1) {
          // Extract start and end times for each slot
          $times = explode('_', $requests[$i]['slots'][$j]);

          // Add slots' start and end times
          $requests[$i]['slots'][$j] = array(
            'start_time' => $times[0],
            'end_time' => $times[1],
          );
        }
      }

      return $requests;
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }
}
