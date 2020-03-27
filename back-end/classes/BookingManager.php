<?php

/**
 * Class for the BookingManager component.
 *
 * @category Core Component
 */

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
   * Retrieves all the appointments booked at the medical facility.
   *
   * @return array Appointments booked at the medical facility.
   */
  public static function getAppointments() {
    // Define JOIN tables
    $join_tables = array('request', 'patient', 'appointment_type', 'language', 'availability', 'slot', 'staff');

    // Define JOIN conditions
    $join_conditions = array(
      'request_id = request.id',
      'patient_id = patient.id',
      'appointment_type = appointment_type.id',
      'translation = language.id',
      'availability_id = availability.id',
      'slot_id = slot.id',
      'staff_id = staff.id',
    );

    // Define conditions to be checked in query
    $selections = array(
      '' => array(
        'comparison' => 'NOT',
        'param' => ':cancelled',
        'value' => 'cancelled',
      ),
    );

    // Define columns to select
    $projections = array(
      'appointment.id',
      'start_time',
      'reason',
      "CONCAT(staff.title, ' ', staff.forename, ' ', staff.surname) AS staff",
      'reason',
      'language.name AS translation',
      'appointment_type.title AS appointment_type',
      'appointment.cancelled',
      'patient.id AS patient_id',
      'patient.contact_by_email',
      'patient.contact_by_text',
    );

    try {
      // Retrieve all booked appointments
      $appointments = $GLOBALS['app']->getDB()->selectJoinWhere('appointment', $join_tables, $join_conditions, $selections, $projections);

      return $appointments;
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Retrieves all the appointments made by a patient, or for a medical staff member (who was assigned), referencing their account ID.
   *
   * @param string $userId Account ID of the patient or medical staff member for which to display appointments.
   * @param string $userType Account type of the user (patient or medical staff member) for which to display appointments.
   * @return array $requests Appointments made by the patient or for a medical staff member (who was assigned).
   */
  public static function getOwnAppointments($userId, $userType) {
    // Define JOIN tables
    $join_tables = array('request', 'patient', 'appointment_type', 'language', 'availability', 'slot', 'staff');

    // Define JOIN conditions
    $join_conditions = array(
      'request_id = request.id',
      'patient_id = patient.id',
      'appointment_type = appointment_type.id',
      'translation = language.id',
      'availability_id = availability.id',
      'slot_id = slot.id',
      'staff_id = staff.id',
    );

    // Define conditions to be checked in query based on the type of user
    $selections = array();

    if ($userType === 'patient') {
      $selections = array(
        'patient_id' => array(
          'comparison' => '=',
          'param' => ':patient_id',
          'value' => $userId,
        ),
      );
    } else {
      $selections = array(
        'staff_id' => array(
          'comparison' => '=',
          'param' => ':staff_id',
          'value' => $userId,
        ),
      );
    }

    // Define columns to select
    $projections = array(
      'appointment.id',
      'start_time',
      'reason',
      "CONCAT(staff.title, ' ', staff.forename, ' ', staff.surname) AS staff",
      'reason',
      'language.name AS translation',
      'appointment_type.title AS appointment_type',
      'appointment.cancelled',
      'patient.id AS patient_id',
      'patient.contact_by_email',
      'patient.contact_by_text',
    );

    try {
      // Retrieve all appointments made by the patient, or for the medical staff member
      $requests = $GLOBALS['app']->getDB()->selectJoinWhere('appointment', $join_tables, $join_conditions, $selections, $projections);

      return $requests;
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Cancels a patient's booked appointment using the given appointment data.
   *
   * @param array $data Collection of appointment details.
   * @return void
   */
  public static function cancelAppointment($data) {
    // Validate the appointment details
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
          // Set booker's cancellation reason
          $cancellation_reason_column = 'b_cancellation_reason';
        }

        // Define columns to be updated, depending on the user's role
        $update_columns[$cancellation_reason_column] = array(
          'param' => ":$cancellation_reason_column",
          'value' => strlen($data['cancellation_reason']) > 0 ? $data['cancellation_reason'] : null,
        );

        // Cancel the specified appointment
        $cancellation_result = $GLOBALS['app']->getDB()->updateWhere('appointment', $selections, $update_columns);

        if ($cancellation_result) {
          $GLOBALS['successes'][] = 'Your appointment has been successfully cancelled.';

          // Define message to be sent via the user's contact preferences
          $message = "Your appointment has been cancelled";
          $message .= isset($data['cancellation_reason']) ? ' for the following reason: "' . $data['cancellation_reason'] . '".' : '.';

          if ($_SESSION['user']->role_id == PATIENT_ROLE) {
            if ($_SESSION['user']->contact_by_email) {
              UserManager::receiveEmail($_SESSION['user']->id, $message);
            }
            if ($_SESSION['user']->contact_by_text) {
              UserManager::receiveSms($_SESSION['user']->id, $message);
            }
          } else {
            if ($data['patient_contact_by_email']) {
              UserManager::receiveEmail($data['patient_id'], $message);
            }
            if ($data['patient_contact_by_text']) {
              UserManager::receiveSms($data['patient_id'], $message);
            }
          }
        } else {
          $GLOBALS['errors'][] = 'An unexpected error has occurred. Please check the appointment you selected and try again.';
        }
      } catch (PDOException $e) {
        $GLOBALS['errors'][] = $e->getMessage();
      }
    } else {
      $GLOBALS['errors'][] = 'Sorry, the appointment could not be cancelled using the given details. Please check your selection and reason and try again.';
    }
  }

  /**
   * Checks whether the appointment's details exist so that it is able to be cancelled.
   *
   * @param array $data Collection of appointment details.
   * @return boolean Whether the appointment details pass (true) or fail (false) validation.
   */
  private static function validateCancellation($data) {
    $reason_limit = 255;
    $valid_id = false;

    // Check if the given ID matches an ID of one of the appointments
    foreach ($data['appointments'] as $appointment) {
      if ($appointment['id'] === $data['to_cancel']) {
        $valid_id = true;
        break;
      }
    }

    if (empty($data['to_cancel']) || !$valid_id) {
      $GLOBALS['errors'][] = 'Please select an existing appointment.';
    } elseif (strlen($data['cancellation_reason']) > $reason_limit) {
      $GLOBALS['errors'][] = 'Please ensure the cancellation reason does not exceed 255 characters.';
    } else {
      return true;
    }

    return false;
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
