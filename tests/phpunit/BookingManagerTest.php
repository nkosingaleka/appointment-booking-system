<?php

require 'data/UserTestData.php';
require 'data/AppointmentTestData.php';

use PHPUnit\Framework\TestCase;

class BookingManagerTest extends TestCase {
  public function setUp(): void {
    $GLOBALS['errors'] = array();
    $GLOBALS['successes'] = array();
  }

  public function logPatientIn($id) {
    $email = $GLOBALS['verified_users']["patient-$id"]['email'];
    $password = $GLOBALS['valid_password'];

    // Log in to patient account
    UserManager::login($email, $password);
  }

  public function logMedicalStaffIn($id) {
    $email = $GLOBALS['verified_users']["medical-$id"]['email'];
    $password = $GLOBALS['valid_password'];

    // Log in to medical staff account
    UserManager::login($email, $password);
  }

  public function logAdministrativeStaffIn($id) {
    $email = $GLOBALS['verified_users']["administrative-$id"]['email'];
    $password = $GLOBALS['valid_password'];

    // Log in to administrative staff account
    UserManager::login($email, $password);
  }

  public function logOut(): void {
    // Log out to destroy user sessions
    include dirname(__FILE__) . '/../../front-end/scripts/logout.php';
  }

  public function tearDown(): void {
    $this->logOut();
  }

  public function testAppointmentCanBeBooked() {
    $requests = $GLOBALS['new_appointments'];
    $administrative_staff = array(
      $GLOBALS['verified_users']['administrative-1'],
      $GLOBALS['verified_users']['administrative-2'],
    );

    foreach ($administrative_staff as $staff) {
      foreach ($requests as $request) {
        $request['booker_id'] = $staff['id'];

        BookingManager::bookAppointment($request);

        $this->assertEmpty($GLOBALS['errors']);
        $this->assertNotEmpty($GLOBALS['successes']);
        $this->assertContains('The appointment has been successfully booked.', $GLOBALS['successes']);

        $GLOBALS['app']->getDB()->rawSQL("DELETE FROM appointment_booking_system.appointment WHERE id NOT IN ('ap-5e777c661e2a32.80096338', 'ap-5e777c661e2a32.34520912', 'ap-5e777c661e2a32.23234569', 'ap-5e777c661e2a32.15394056')");
      }
    }
  }

  public function testBookAppointmentDoesNotValidateEmptyRequestId() {
    $requests = $GLOBALS['new_appointments'];
    $administrative_staff = array(
      $GLOBALS['verified_users']['administrative-1'],
      $GLOBALS['verified_users']['administrative-2'],
    );

    foreach ($administrative_staff as $staff) {
      foreach ($requests as $request) {
        $request['request_id'] = '';
        $request['booker_id'] = $staff['id'];

        BookingManager::bookAppointment($request);

        $this->assertEmpty($GLOBALS['successes']);
        $this->assertNotEmpty($GLOBALS['errors']);
        $this->assertContains('Please select an existing appointment booking request.', $GLOBALS['errors']);
        $this->assertContains('Sorry, your selections were in an incorrect format. Please check them and try again.', $GLOBALS['errors']);
      }
    }
  }

  public function testBookAppointmentDoesNotValidateEmptyAvailabilityId() {
    $requests = $GLOBALS['new_appointments'];
    $administrative_staff = array(
      $GLOBALS['verified_users']['administrative-1'],
      $GLOBALS['verified_users']['administrative-2'],
    );

    foreach ($administrative_staff as $staff) {
      foreach ($requests as $request) {
        $request['availability_id'] = '';
        $request['booker_id'] = $staff['id'];

        BookingManager::bookAppointment($request);

        $this->assertEmpty($GLOBALS['successes']);
        $this->assertNotEmpty($GLOBALS['errors']);

        $this->assertContains('An unexpected error has occurred. Please check your input and try again.', $GLOBALS['errors']);
      }
    }
  }

  public function testAppointmentsCanBeRetrieved() {
    $appointments = BookingManager::getAppointments();

    $this->assertIsArray($appointments);
    $this->assertNotEmpty($appointments);

    foreach ($GLOBALS['existing_appointments'] as $existing) {
      foreach ($appointments as $appointment) {
        $this->assertIsArray($appointment);
        $this->assertNotEmpty($appointment);

        if ($appointment['id'] == $existing['id']) {
          $this->assertIsString($appointment['id']);
          $this->assertIsString($appointment['start_time']);
          $this->assertEquals($appointment['start_time'], $existing['start_time']);
          $this->assertIsString($appointment['reason']);
          $this->assertEquals($appointment['reason'], $existing['reason']);
          $this->assertIsString($appointment['staff']);
          $this->assertEquals($appointment['staff'], $existing['staff']);
          $this->assertIsString($appointment['translation']);
          $this->assertEquals($appointment['translation'], $existing['translation']);
          $this->assertIsString($appointment['appointment_type']);
          $this->assertEquals($appointment['appointment_type'], $existing['appointment_type']);
          $this->assertNotNull($appointment['cancelled']);
          $this->assertIsString($appointment['patient_id']);
          $this->assertEquals($appointment['patient_id'], $existing['patient_id']);
          $this->assertNotNull($appointment['contact_by_email']);
          $this->assertNotNull($appointment['contact_by_text']);
        }
      }
    }
  }

  public function testStaffOwnAppointmentsCanBeRetrieved() {
    $medical_staff = array(
      $GLOBALS['verified_users']['medical-1'],
      $GLOBALS['verified_users']['medical-2'],
    );

    foreach ($medical_staff as $staff) {
      $appointments = BookingManager::getOwnAppointments($staff['id'], 'staff');

      $this->assertIsArray($appointments);
      $this->assertNotEmpty($appointments);

      for ($i = 0; $i < count($appointments); $i += 1) {
        $this->assertIsString($appointments[$i]['id']);
        $this->assertIsString($appointments[$i]['start_time']);
        $this->assertIsString($appointments[$i]['reason']);
        $this->assertIsString($appointments[$i]['staff']);
        $this->assertIsString($appointments[$i]['translation']);
        $this->assertIsString($appointments[$i]['appointment_type']);
        $this->assertIsString($appointments[$i]['patient_id']);
        $this->assertNotNull($appointments[$i]['contact_by_email']);
        $this->assertNotNull($appointments[$i]['contact_by_text']);
      }
    }
  }

  public function testPatientOwnAppointmentsCanBeRetrieved() {
    $patients = array(
      $GLOBALS['verified_users']['patient-1'],
      $GLOBALS['verified_users']['patient-2'],
    );

    foreach ($patients as $patient) {
      $appointments = BookingManager::getOwnAppointments($patient['id'], 'patient');

      $this->assertIsArray($appointments);
      $this->assertNotEmpty($appointments);

      for ($i = 0; $i < count($appointments); $i += 1) {
        $this->assertIsString($appointments[$i]['id']);
        $this->assertIsString($appointments[$i]['start_time']);
        $this->assertIsString($appointments[$i]['reason']);
        $this->assertIsString($appointments[$i]['staff']);
        $this->assertIsString($appointments[$i]['translation']);
        $this->assertIsString($appointments[$i]['appointment_type']);
        $this->assertIsString($appointments[$i]['patient_id']);
        $this->assertNotNull($appointments[$i]['contact_by_email']);
        $this->assertNotNull($appointments[$i]['contact_by_text']);
      }
    }
  }

  public function testAppointmentCannotBeCancelledWithoutAppointmentIdToCancel() {
    $data = $GLOBALS['example_appointment_cancellation'];
    $data['to_cancel'] = '';

    BookingManager::cancelAppointment($data);

    $this->assertEmpty($GLOBALS['successes']);
    $this->assertNotEmpty($GLOBALS['errors']);
    $this->assertContains('Please select an existing appointment.', $GLOBALS['errors']);
    $this->assertContains('Sorry, the appointment could not be cancelled using the given details. Please check your selection and reason and try again.', $GLOBALS['errors']);
  }

  public function testAppointmentCannotBeCancelledWithoutAppointmentIds() {
    $data = $GLOBALS['example_appointment_cancellation'];

    for ($i = 0; $i < count($data['appointments']); $i += 1) {
      $data['appointments'][$i]['id'] = '';
    }

    BookingManager::cancelAppointment($data);

    $this->assertEmpty($GLOBALS['successes']);
    $this->assertNotEmpty($GLOBALS['errors']);
    $this->assertContains('Please select an existing appointment.', $GLOBALS['errors']);
    $this->assertContains('Sorry, the appointment could not be cancelled using the given details. Please check your selection and reason and try again.', $GLOBALS['errors']);
  }

  public function testAppointmentCannotBeCancelledWithReasonOver255Characters() {
    $data = $GLOBALS['example_appointment_cancellation'];
    $data['cancellation_reason'] = $GLOBALS['cancellation_reason_256'];

    BookingManager::cancelAppointment($data);

    $this->assertEmpty($GLOBALS['successes']);
    $this->assertNotEmpty($GLOBALS['errors']);
    $this->assertContains('Please ensure the cancellation reason does not exceed 255 characters.', $GLOBALS['errors']);
    $this->assertContains('Sorry, the appointment could not be cancelled using the given details. Please check your selection and reason and try again.', $GLOBALS['errors']);
  }

  public function testPatientCanCancelAppointmentWithValidCancellationData() {
    for ($i = 1; $i < 2; $i += 1) {
      $this->logPatientIn($i);

      $reasons = array(
        $GLOBALS['example_appointment_cancellation']['cancellation_reason'],
        $GLOBALS['cancellation_reason_255'],
      );

      $data = $GLOBALS['example_appointment_cancellation'];

      for ($r = 0; $r < count($reasons); $r += 1) {
        $data['cancellation_reason'] = $reasons[$r];

        BookingManager::cancelAppointment($data);

        $this->assertEmpty($GLOBALS['errors']);
        $this->assertNotEmpty($GLOBALS['successes']);
        $this->assertContains('Your appointment has been successfully cancelled.', $GLOBALS['successes']);

        $selections = array(
          'id' => array(
            'comparison' => '=',
            'param' => ':id',
            'value' => $data['to_cancel'],
          ),
        );

        $projections = array(
          'cancelled',
          'p_cancellation_reason',
          'b_cancellation_reason',
        );

        // Check if updated in database
        $cancelled = $GLOBALS['app']->getDB()->selectOneWhere('appointment', $selections, $projections);

        $this->assertNotEmpty($cancelled);
        $this->assertEquals($cancelled['cancelled'], true);
        $this->assertIsString($cancelled['p_cancellation_reason']);
        $this->assertEquals($cancelled['p_cancellation_reason'],
          $data['cancellation_reason']);
        $this->assertNull($cancelled['b_cancellation_reason']);

        $update_columns = array(
          'cancelled' => array(
            'param' => ':cancelled',
            'value' => false,
          ),
          'p_cancellation_reason' => array(
            'param' => ':reason',
            'value' => null,
          ),
        );

        // // Un-cancel appointment for further tests
        $uncancel_result = $GLOBALS['app']->getDB()->updateWhere('appointment', $selections, $update_columns);
      }
    }
  }

  public function testAdministrativeStaffCanCancelAppointmentWithValidCancellationData() {
    for ($i = 1; $i < 2; $i += 1) {
      $this->logAdministrativeStaffIn($i);

      $reasons = array(
        $GLOBALS['example_appointment_cancellation']['cancellation_reason'],
        $GLOBALS['cancellation_reason_255'],
      );

      $data = $GLOBALS['example_appointment_cancellation'];

      for ($r = 0; $r < count($reasons); $r += 1) {
        $data['cancellation_reason'] = $reasons[$r];

        BookingManager::cancelAppointment($data);
  
        $this->assertEmpty($GLOBALS['errors']);
        $this->assertNotEmpty($GLOBALS['successes']);
        $this->assertContains('Your appointment has been successfully cancelled.', $GLOBALS['successes']);
  
        $selections = array(
          'id' => array(
            'comparison' => '=',
            'param' => ':id',
            'value' => $data['to_cancel'],
          ),
        );
  
        $projections = array(
          'cancelled',
          'p_cancellation_reason',
          'b_cancellation_reason',
        );
  
        // Check if updated in database
        $cancelled = $GLOBALS['app']->getDB()->selectOneWhere('appointment', $selections, $projections);
  
        $this->assertNotEmpty($cancelled);
        $this->assertEquals($cancelled['cancelled'], true);
        $this->assertIsString($cancelled['b_cancellation_reason']);
        $this->assertEquals($cancelled['b_cancellation_reason'],
          $data['cancellation_reason']);
        $this->assertNull($cancelled['p_cancellation_reason']);
  
        $update_columns = array(
          'cancelled' => array(
            'param' => ':cancelled',
            'value' => false,
          ),
          'b_cancellation_reason' => array(
            'param' => ':reason',
            'value' => null,
          ),
        );
  
        // // Un-cancel appointment for further tests
        $uncancel_result = $GLOBALS['app']->getDB()->updateWhere('appointment', $selections, $update_columns);
      }
    }
  }

  public function testMedicalStaffCanCancelAppointmentWithValidCancellationData() {
    for ($i = 1; $i < 2; $i += 1) {
      $this->logMedicalStaffIn($i);

      $reasons = array(
        $GLOBALS['example_appointment_cancellation']['cancellation_reason'],
        $GLOBALS['cancellation_reason_255'],
      );

      $data = $GLOBALS['example_appointment_cancellation'];

      for ($r = 0; $r < count($reasons); $r += 1) {
        $data['cancellation_reason'] = $reasons[$r];

        BookingManager::cancelAppointment($data);
  
        $this->assertEmpty($GLOBALS['errors']);
        $this->assertNotEmpty($GLOBALS['successes']);
        $this->assertContains('Your appointment has been successfully cancelled.', $GLOBALS['successes']);
  
        $selections = array(
          'id' => array(
            'comparison' => '=',
            'param' => ':id',
            'value' => $data['to_cancel'],
          ),
        );
  
        $projections = array(
          'cancelled',
          'p_cancellation_reason',
          'b_cancellation_reason',
        );
  
        // Check if updated in database
        $cancelled = $GLOBALS['app']->getDB()->selectOneWhere('appointment', $selections, $projections);
  
        $this->assertNotEmpty($cancelled);
        $this->assertEquals($cancelled['cancelled'], true);
        $this->assertIsString($cancelled['b_cancellation_reason']);
        $this->assertEquals($cancelled['b_cancellation_reason'],
          $data['cancellation_reason']);
        $this->assertNull($cancelled['p_cancellation_reason']);
  
        $update_columns = array(
          'cancelled' => array(
            'param' => ':cancelled',
            'value' => false,
          ),
          'b_cancellation_reason' => array(
            'param' => ':reason',
            'value' => null,
          ),
        );
  
        // // Un-cancel appointment for further tests
        $uncancel_result = $GLOBALS['app']->getDB()->updateWhere('appointment', $selections, $update_columns);
      }
    }
  }
}
