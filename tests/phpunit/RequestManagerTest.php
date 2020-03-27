<?php

require 'data/UserTestData.php';
require 'data/RequestTestData.php';
require 'data/SlotTestData.php';

use PHPUnit\Framework\TestCase;

class RequestManagerTest extends TestCase {
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

  public function logOut(): void {
    // Log out to destroy user sessions
    include dirname(__FILE__) . '/../../front-end/scripts/logout.php';
  }

  public function tearDown(): void {
    $this->logOut();
  }

  public function testMakeRequestDoesNotValidateEmptyTranslationRequired() {
    $medical_staff = array(
      $GLOBALS['verified_users']['medical-1'],
      $GLOBALS['verified_users']['medical-2'],
    );

    for ($i = 1; $i <= 2; $i += 1) {
      $this->logPatientIn($i);

      $data = array(
        'patient_id' => $_SESSION['user']->id,
        'slots' => $GLOBALS['example_slots'],
      );

      foreach (array_keys($GLOBALS['example_reasons']) as $reason) {
        $data['appointment_reason'] = $GLOBALS['example_reasons'][$reason];

        foreach ($medical_staff as $staff) {
          $data['staff_choice'] = $staff['id'];

          RequestManager::makeRequest($data);

          $this->assertNotEmpty($GLOBALS['errors']);
          $this->assertContains('Please select a translation option.', $GLOBALS['errors']);
          $this->assertContains('Sorry, your details were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
        }
      }
    }
  }

  public function testMakeRequestDoesNotValidateEmptyPreferredStaff() {
    for ($i = 1; $i <= 2; $i += 1) {
      $this->logPatientIn($i);

      $data = array(
        'patient_id' => $_SESSION['user']->id,
        'slots' => $GLOBALS['example_slots'],
      );

      foreach (array_keys($GLOBALS['example_reasons']) as $reason) {
        $data['appointment_reason'] = $GLOBALS['example_reasons'][$reason];

        foreach (array_keys($GLOBALS['available_translations']) as $translation) {
          $data['translation_choice'] = $GLOBALS['available_translations'][$translation]['id'];

          RequestManager::makeRequest($data);

          $this->assertNotEmpty($GLOBALS['errors']);
          $this->assertContains('Please select a staff member.', $GLOBALS['errors']);
          $this->assertContains('Sorry, your details were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
        }
      }
    }
  }

  public function testMakeRequestDoesNotValidateEmptySlots() {
    $medical_staff = array(
      $GLOBALS['verified_users']['medical-1'],
      $GLOBALS['verified_users']['medical-2'],
    );

    for ($i = 1; $i <= 2; $i += 1) {
      $this->logPatientIn($i);

      $data = array(
        'patient_id' => $_SESSION['user']->id,
      );

      foreach (array_keys($GLOBALS['example_reasons']) as $reason) {
        $data['appointment_reason'] = $GLOBALS['example_reasons'][$reason];

        foreach (array_keys($GLOBALS['available_translations']) as $translation) {
          $data['translation_choice'] = $GLOBALS['available_translations'][$translation]['id'];

          foreach ($medical_staff as $staff) {
            $data['staff_choice'] = $staff['id'];

            RequestManager::makeRequest($data);

            $this->assertNotEmpty($GLOBALS['errors']);
            $this->assertContains('Please select at least one time slot.', $GLOBALS['errors']);
            $this->assertContains('Sorry, your details were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
          }
        }
      }
    }
  }

  public function testExistingRequestsCanBeRetrieved() {
    foreach ($GLOBALS['existing_requests'] as $existing_request) {
      if (!$existing_request['cancelled'] && isset($existing_request['appointment_type'])) {
        $request = RequestManager::getRequest($existing_request['id']);

        $this->assertIsArray($request);
        $this->assertNotEmpty($request);
        $this->assertIsString($request['id']);
        $this->assertEquals($request['id'], $existing_request['id']);
        $this->assertIsString($request['patient']);
        $this->assertEquals($request['patient'], $existing_request['patient']);
        $this->assertIsString($request['staff']);
        $this->assertEquals($request['staff'], $existing_request['staff']);

        $this->assertIsArray($request['slots']);

        for ($i = 0; $i < count($request['slots']); $i += 1) {
          for ($j = 0; $j < count($existing_request['slots']); $j += 1) {
            $this->assertEquals($request['slots'][$i]['start_time'], $existing_request['slots'][$i]['start_time']);
            $this->assertEquals($request['slots'][$i]['end_time'], $existing_request['slots'][$i]['end_time']);
          }
        }

        $this->assertIsString($request['patient_id']);
        $this->assertEquals($request['patient_id'], $existing_request['patient_id']);
        $this->assertNotNull($request['cancelled']);
        $this->assertNotNull($request['contact_by_email']);
        $this->assertNotNull($request['contact_by_text']);
        $this->assertIsString($request['appointment_type']);
        $this->assertEquals($request['appointment_type'], $existing_request['appointment_type']);
        $this->assertIsString($request['appointment_type_title']);
        $this->assertEquals($request['appointment_type_title'], $existing_request['appointment_type_title']);
      }
    }
  }

  public function testStaffOwnRequestsCanBeRetrieved() {
    $medical_staff = array(
      $GLOBALS['verified_users']['medical-1'],
      $GLOBALS['verified_users']['medical-2'],
    );

    foreach ($medical_staff as $staff) {
      $requests = RequestManager::getOwnRequests($staff['id'], 'staff');

      $this->assertIsArray($requests);
      $this->assertNotEmpty($requests);

      for ($i = 0; $i < count($requests); $i += 1) {
        $this->assertIsArray($requests[$i]);
        $this->assertNotEmpty($requests[$i]);
        $this->assertIsString($requests[$i]['id']);
        $this->assertIsString($requests[$i]['reason']);
        $this->assertIsString($requests[$i]['translation']);
        $this->assertIsString($requests[$i]['staff']);

        $this->assertIsArray($requests[$i]['slots']);

        $this->assertNotNull($requests[$i]['cancelled']);
        $this->assertIsString($requests[$i]['patient_id']);
        $this->assertNotNull($requests[$i]['contact_by_email']);
        $this->assertNotNull($requests[$i]['contact_by_text']);

        if (isset($requests[$i]['appointment_type'])) {
          $this->assertIsString($requests[$i]['appointment_type']);
        }
      }
    }
  }

  public function testPatientOwnRequestsCanBeRetrieved() {
    $patients = array(
      $GLOBALS['verified_users']['patient-1'],
      $GLOBALS['verified_users']['patient-2'],
    );

    foreach ($patients as $patient) {
      $requests = RequestManager::getOwnRequests($patient['id'], 'patient');

      $this->assertIsArray($requests);
      $this->assertNotEmpty($requests);

      for ($i = 0; $i < count($requests); $i += 1) {
        $this->assertIsArray($requests[$i]);
        $this->assertNotEmpty($requests[$i]);
        $this->assertIsString($requests[$i]['id']);
        $this->assertIsString($requests[$i]['reason']);
        $this->assertIsString($requests[$i]['translation']);
        $this->assertIsString($requests[$i]['staff']);

        $this->assertIsArray($requests[$i]['slots']);

        $this->assertNotNull($requests[$i]['cancelled']);
        $this->assertIsString($requests[$i]['patient_id']);
        $this->assertNotNull($requests[$i]['contact_by_email']);
        $this->assertNotNull($requests[$i]['contact_by_text']);

        if (isset($requests[$i]['appointment_type'])) {
          $this->assertIsString($requests[$i]['appointment_type']);
        }
      }
    }
  }

  public function testApprovedRequestsCanBeRetrieved() {
    $approved_requests = RequestManager::getApprovedRequests();

    $this->assertIsArray($approved_requests);
    $this->assertNotEmpty($approved_requests);

    foreach ($approved_requests as $approved) {
      foreach ($GLOBALS['existing_requests'] as $existing) {
        if (isset($existing_request['appointment_type'])) {
          $this->assertIsString($approved['id']);
          $this->assertEquals($approved['id'], $existing['id']);
          $this->assertIsString($approved['reason']);
          $this->assertEquals($approved['reason'], $existing['reason']);
          $this->assertIsString($approved['translation']);
          $this->assertEquals($approved['translation'], $existing['translation']);
          $this->assertIsString($approved['staff']);
          $this->assertEquals($approved['staff'], $existing['staff']);

          for ($i = 0; $i < count($approved['slots']); $i += 1) {
            for ($j = 0; $j < count($existing['slots']); $j += 1) {
              $this->assertEquals($approved['slots'][$i]['start_time'], $existing['slots'][$i]['start_time']);
              $this->assertEquals($approved['slots'][$i]['end_time'], $existing['slots'][$i]['end_time']);
            }
          }

          $this->assertFalse((boolean) $approved['cancelled']);
          $this->assertIsString($approved['patient_id']);
          $this->assertEquals($approved['patient_id'], $existing['patient_id']);
          $this->assertNotNull($approved['contact_by_email']);
          $this->assertNotNull($approved['contact_by_text']);
          $this->assertIsString($approved['appointment_type']);
          $this->assertEquals($approved['appointment_type'], $existing['appointment_type']);
        }
      }
    }
  }

  public function testRequestCannotBeCancelledWithoutRequestId() {
    $data = array(
      'to_cancel' => '',
      'cancellation_reason' => $GLOBALS['example_request_cancellation']['cancellation_reason'],
      'requests' => $GLOBALS['example_request_cancellation']['requests'],
      'patient_contact_by_email' => $GLOBALS['example_request_cancellation']['patient_contact_by_email'],
      'patient_contact_by_text' => $GLOBALS['example_request_cancellation']['patient_contact_by_text'],
    );

    RequestManager::cancelRequest($data);

    $this->assertEmpty($GLOBALS['successes']);
    $this->assertNotEmpty($GLOBALS['errors']);
    $this->assertContains('Please select an existing appointment booking request.', $GLOBALS['errors']);
    $this->assertContains('Sorry, the appointment booking request could not be cancelled using the given details. Please check your selection and reason and try again.', $GLOBALS['errors']);
  }

  public function testRequestCannotBeCancelledWithReasonOver255Characters() {
    $data = array(
      'to_cancel' => $GLOBALS['example_request_cancellation']['to_cancel'],
      'cancellation_reason' => $GLOBALS['cancellation_reason_256'],
      'requests' => $GLOBALS['example_request_cancellation']['requests'],
      'patient_contact_by_email' => $GLOBALS['example_request_cancellation']['patient_contact_by_email'],
      'patient_contact_by_text' => $GLOBALS['example_request_cancellation']['patient_contact_by_text'],
    );

    RequestManager::cancelRequest($data);

    $this->assertEmpty($GLOBALS['successes']);
    $this->assertNotEmpty($GLOBALS['errors']);
    $this->assertContains('Please ensure the cancellation reason does not exceed 255 characters.', $GLOBALS['errors']);
    $this->assertContains('Sorry, the appointment booking request could not be cancelled using the given details. Please check your selection and reason and try again.', $GLOBALS['errors']);
  }

  public function testRequestCanBeCancelledByStaffWithValidCancellationData() {
    $reasons = array(
      $GLOBALS['example_request_cancellation']['cancellation_reason'],
      $GLOBALS['cancellation_reason_255'],
    );

    $data = array(
      'to_cancel' => $GLOBALS['example_request_cancellation']['to_cancel'],
      'requests' => $GLOBALS['example_request_cancellation']['requests'],
      'patient_contact_by_email' => $GLOBALS['example_request_cancellation']['patient_contact_by_email'],
      'patient_contact_by_text' => $GLOBALS['example_request_cancellation']['patient_contact_by_text'],
    );

    $this->logMedicalStaffIn(1);

    // Test with reason < 255 and 255 characters in length
    for ($i = 0; $i < 2; $i += 1) {
      $data['cancellation_reason'] = $reasons[$i];

      RequestManager::cancelRequest($data);

      $this->assertEmpty($GLOBALS['errors']);
      $this->assertNotEmpty($GLOBALS['successes']);
      $this->assertContains('Your appointment booking request has been successfully cancelled.', $GLOBALS['successes']);

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
        'r_cancellation_reason',
      );

      // Check if updated in database
      $cancelled = $GLOBALS['app']->getDB()->selectOneWhere('request', $selections, $projections);

      $this->assertNotEmpty($cancelled);
      $this->assertEquals($cancelled['cancelled'], true);
      $this->assertNull($cancelled['p_cancellation_reason']);
      $this->assertIsString($cancelled['r_cancellation_reason']);
      $this->assertEquals($cancelled['r_cancellation_reason'], $data['cancellation_reason']);

      $update_columns = array(
        'cancelled' => array(
          'param' => ':cancelled',
          'value' => false,
        ),
        'r_cancellation_reason' => array(
          'param' => ':reason',
          'value' => null,
        ),
        'reviewer_id' => array(
          'param' => ':reviewer_id',
          'value' => null,
        ),
      );

      // Un-cancel request for further tests
      $uncancel_result = $GLOBALS['app']->getDB()->updateWhere('request', $selections, $update_columns);
    }
  }

  public function testRequestCanBeCancelledByPatientsWithValidCancellationData() {
    $reasons = array(
      $GLOBALS['example_request_cancellation']['cancellation_reason'],
      $GLOBALS['cancellation_reason_255'],
    );

    $data = array(
      'to_cancel' => $GLOBALS['example_request_cancellation']['to_cancel'],
      'requests' => $GLOBALS['example_request_cancellation']['requests'],
      'patient_contact_by_email' => $GLOBALS['example_request_cancellation']['patient_contact_by_email'],
      'patient_contact_by_text' => $GLOBALS['example_request_cancellation']['patient_contact_by_text'],
    );

    $this->logPatientIn(1);

    // Test with reason < 255 and 255 characters in length
    for ($i = 0; $i < 2; $i += 1) {
      $data['cancellation_reason'] = $reasons[$i];

      RequestManager::cancelRequest($data);

      $this->assertEmpty($GLOBALS['errors']);
      $this->assertNotEmpty($GLOBALS['successes']);
      $this->assertContains('Your appointment booking request has been successfully cancelled.', $GLOBALS['successes']);

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
        'r_cancellation_reason',
      );

      // Check if updated in database
      $cancelled = $GLOBALS['app']->getDB()->selectOneWhere('request', $selections, $projections);

      $this->assertNotEmpty($cancelled);
      $this->assertEquals($cancelled['cancelled'], true);
      $this->assertNull($cancelled['r_cancellation_reason']);
      $this->assertIsString($cancelled['p_cancellation_reason']);
      $this->assertEquals($cancelled['p_cancellation_reason'], $data['cancellation_reason']);

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

      // Un-cancel request for further tests
      $uncancel_result = $GLOBALS['app']->getDB()->updateWhere('request', $selections, $update_columns);
    }
  }

  public function testAppointmentTypesCanBeRetrieved() {
    $appointment_types = RequestManager::getAppointmentTypes();

    $this->assertIsArray($appointment_types);

    for ($i = 0; $i < count($appointment_types); $i += 1) {
      $this->assertIsString($appointment_types[$i]['id']);
      $this->assertEquals($appointment_types[$i]['id'], $GLOBALS['appointment_types'][$i]['id']);
      $this->assertIsString($appointment_types[$i]['title']);
      $this->assertEquals($appointment_types[$i]['title'], $GLOBALS['appointment_types'][$i]['title']);
    }
  }

  public function testAppointmentTypesCanBeAssigned() {
    foreach ($GLOBALS['existing_requests'] as $existing) {
      if (!isset($existing['appointment_type'])) {
        for ($i = 0; $i < count($GLOBALS['appointment_types']); $i += 1) {
          RequestManager::assignAppointmentType($existing['id'], $GLOBALS['appointment_types'][$i]['id']);

          $this->assertEmpty($GLOBALS['errors']);
          $this->assertNotEmpty($GLOBALS['successes']);
          $this->assertContains('The type of appointment needed for the appointment booking request has been successfully set.', $GLOBALS['successes']);

          $selections = array(
            'id' => array(
              'comparison' => '=',
              'param' => ':id',
              'value' => $existing['id'],
            ),
          );

          // Check if updated in database
          $assignment_result = $GLOBALS['app']->getDB()->selectOneWhere('request', $selections, ['appointment_type']);

          $this->assertIsString($assignment_result['appointment_type']);
          $this->assertEquals($assignment_result['appointment_type'], $GLOBALS['appointment_types'][$i]['id']);

          $update_columns = array(
            'appointment_type' => array(
              'param' => ':appointment_type',
              'value' => null,
            ),
          );

          // Un-assign for future requests
          $unassignment_result = $GLOBALS['app']->getDB()->updateWhere('request', $selections, $update_columns);
        }
      }
    }
  }

  public function testAppointmentTypesCannotBeAssignedWithEmptyRequestId() {
    foreach ($GLOBALS['existing_requests'] as $existing) {
      if (!isset($existing['appointment_type'])) {
        for ($i = 0; $i < count($GLOBALS['appointment_types']); $i += 1) {
          RequestManager::assignAppointmentType(null, $GLOBALS['appointment_types'][$i]['id']);

          $selections = array(
            'id' => array(
              'comparison' => '=',
              'param' => ':id',
              'value' => null,
            ),
          );

          // Check if updated in database
          $assignment_result = $GLOBALS['app']->getDB()->selectOneWhere('request', $selections, ['appointment_type']);

          $this->assertEmpty($assignment_result);
        }
      }
    }
  }
}
