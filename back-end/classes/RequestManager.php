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
   * Retrieves all the appointment booking requests made by a patient, or for a medical staff member (who was preferred), referencing their account ID.
   *
   * @param string $userId Account ID of the patient or medical staff member for which to display appointment booking requests.
   * @param string $userType Account type of the user (patient or medical staff member) for which to display appointment booking requests.
   * @return array $requests Appointment Booking Requests made by the patient or for a medical staff member (who was preferred).
   */
  public static function getOwnRequests($userId, $userType) {
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

    // Define conditions to be checked in query based on the type of user
    $selections = array();

    if ($userType === 'patient') {
    $selections = array(
      'patient_id' => array(
        'comparison' => '=',
        'param' => ':patient_id',
          'value' => $userId,
          'after' => 'GROUP BY request.id',
      ),
    );
    } else {
      $selections = array(
        'preferred_staff' => array(
          'comparison' => '=',
          'param' => ':preferred_staff',
          'value' => $userId,
          'after' => 'GROUP BY request.id',
        ),
      );
    }

    // Define columns to select
    $projections = array(
      'request.id',
      'reason',
      'name AS translation',
      'staff.title',
      'staff.forename',
      'staff.surname',
      "GROUP_CONCAT(start_time, '_', end_time ORDER BY start_time) as 'slots'",
      'cancelled',
    );

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

  /**
   * Cancels a patient's appointment booking request using the given request data.
   *
   * @param array $data Collection of request details and ID of the request to be cancelled.
   * @return void
   */
  public static function cancelRequest($data) {
    // Validate the request details
    $valid = self::validateCancellation($data);

    if ($valid) {
      try {
        // Define conditions to be checked in query
        $selections = array(
          'id' => array(
            'comparison' => '=',
            'param' => ':id',
            'value' => $data['to_cancel'],
          ),
        );

        // Define columns to be updated
        $update_columns = array(
          'cancelled' => array(
            'param' => ':cancelled',
            'value' => true,
          ),
        );

        if ($_SESSION['user']->role_id == PATIENT_ROLE) {
          // Set patient's cancellation reason
          $cancellation_reason_column = 'p_cancellation_reason';
        } else {
          // Set reviewer's cancellation reason
          $cancellation_reason_column = 'r_cancellation_reason';

          // Add the ID of the staff member who reviewed the request
          $update_columns['reviewer_id'] = array(
            'param' => ':reviewer_id',
            'value' => $_SESSION['user']->id,
          );
        }

        // Define columns to be updated, depending on the user's role
        $update_columns[$cancellation_reason_column] = array(
            'param' => ":$cancellation_reason_column",
          'value' => strlen($data['cancellation_reason']) > 0 ? $data['cancellation_reason'] : null,
        );

        // Cancel the specified request
        $cancellation_result = $GLOBALS['app']->getDB()->updateWhere('request', $selections, $update_columns);

        if ($cancellation_result) {
          // To do: handle success messages
          
          // Define message to be sent via the user's contact preferences
          $message = "Your appointment booking request has been cancelled";
          $message .= isset($data['cancellation_reason']) ? ' for the following reason: "' . $data['cancellation_reason'] . '".' : '.';

          if ($_SESSION['user']->contact_by_email) {
            UserManager::receiveEmail($_SESSION['user']->id, $message);
          }
          if ($_SESSION['user']->contact_by_text) {
            UserManager::receiveSms($_SESSION['user']->id, $message);
          }
        } else {
          $GLOBALS['errors'][] = 'An unexpected error has occurred. Please check the appointment booking request you selected and try again.';
        }
      } catch (PDOException $e) {
        $GLOBALS['errors'][] = $e->getMessage();
      }
    } else {
      $GLOBALS['errors'][] = 'Sorry, the appointment booking request could not be cancelled using the given details. Please check your selection and reason and try again.';
    }
  }

  /**
   * Checks whether the appointment booking request's details exist so that it is able to be cancelled.
   *
   * @param array $data Collection of request details and ID of the request to be cancelled.
   * @return boolean Whether the request details pass (true) or fail (false) validation.
   */
  private static function validateCancellation($data) {
    $reason_limit = 255;
    $valid_id = false;

    // Check if the given ID matches an ID of one of the requests
    foreach ($data['requests'] as $request) {
      if ($request['id'] === $data['to_cancel']) {
        $valid_id = true;
        break;
      }
    }

    if (empty($data['to_cancel']) || !$valid_id) {
      $GLOBALS['errors'][] = 'Please select an existing appointment booking request.';
    } elseif (strlen($data['cancellation_reason']) > $reason_limit) {
      $GLOBALS['errors'][] = 'Please ensure the cancellation reason does not exceed 255 characters.';
    } else {
      return true;
    }

    return false;
  }
}
