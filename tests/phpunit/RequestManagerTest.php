<?php

require 'data/UserTestData.php';
require 'data/RequestManagerTestData.php';

use PHPUnit\Framework\TestCase;

class RequestManagerTest extends TestCase {
  public function setUp(): void {
    $GLOBALS['errors'] = array();
  }

  public function logPatientIn() {
    $email = $GLOBALS['verified_users']['patient-1']['email'];
    $password = $GLOBALS['valid_password'];

    // Log in to patient account
    UserManager::login($email, $password);
  }

  public function tearDown(): void {
    // Log out to destroy user sessions
    include dirname(__FILE__) . '/../../front-end/scripts/logout.php';
  }

  public function testMakeRequestDoesNotValidateEmptyTranslationRequired() {
    $this->logPatientIn();

    $data = array(
      'patient_id' => $_SESSION['user']->id,
      'slots' => $GLOBALS['example_slots'],
    );

    foreach (array_keys($GLOBALS['example_reasons']) as $reason) {
      $data['appointment_reason'] = $GLOBALS['example_reasons'][$reason];

      foreach (array_keys($GLOBALS['available_staff']) as $staff) {
        $data['staff_choice'] = $GLOBALS['available_staff'][$staff]['id'];

        RequestManager::makeRequest($data);

        $this->assertContains('Please select a translation option.', $GLOBALS['errors']);
        $this->assertContains('Sorry, your details were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
      }
    }
  }

  public function testMakeRequestDoesNotValidateEmptyPreferredStaff() {
    $this->logPatientIn();

    $data = array(
      'patient_id' => $_SESSION['user']->id,
      'slots' => $GLOBALS['example_slots'],
    );

    foreach (array_keys($GLOBALS['example_reasons']) as $reason) {
      $data['appointment_reason'] = $GLOBALS['example_reasons'][$reason];

      foreach (array_keys($GLOBALS['available_translations']) as $translation) {
        $data['translation_choice'] = $GLOBALS['available_translations'][$translation]['id'];

        RequestManager::makeRequest($data);

        $this->assertContains('Please select a staff member.', $GLOBALS['errors']);
        $this->assertContains('Sorry, your details were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
      }
    }
  }

  public function testMakeRequestDoesNotValidateEmptySlots() {
    $this->logPatientIn();

    $data = array(
      'patient_id' => $_SESSION['user']->id,
    );

    foreach (array_keys($GLOBALS['example_reasons']) as $reason) {
      $data['appointment_reason'] = $GLOBALS['example_reasons'][$reason];

      foreach (array_keys($GLOBALS['available_translations']) as $translation) {
        $data['translation_choice'] = $GLOBALS['available_translations'][$translation]['id'];

        foreach (array_keys($GLOBALS['available_staff']) as $staff) {
          $data['staff_choice'] = $GLOBALS['available_staff'][$staff]['id'];

          RequestManager::makeRequest($data);

          $this->assertContains('Please select at least one time slot.', $GLOBALS['errors']);
          $this->assertContains('Sorry, your details were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
        }
      }
    }
  }
}
