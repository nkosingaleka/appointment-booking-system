<?php

require 'data/UserTestData.php';
require 'data/UserManagerTestData.php';

use PHPUnit\Framework\TestCase;

class UserManagerTest extends TestCase {
  public function setUp(): void {
    $GLOBALS['errors'] = array();
  }

  public function testLoginDoesNotValidateEmptyEmail() {
    $email = '';
    $password = $GLOBALS['valid_password'];

    UserManager::login($email, $password);

    $this->assertNotEmpty($GLOBALS['errors']);
    $this->assertContains('Please enter a valid email address.', $GLOBALS['errors']);
    $this->assertContains('Sorry, your email or password was in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testLoginDoesNotValidateInvalidEmail() {
    $email = $GLOBALS['invalid_email'];
    $password = '';

    UserManager::login($email, $password);

    $this->assertNotEmpty($GLOBALS['errors']);
    $this->assertContains('Please enter a valid email address.', $GLOBALS['errors']);
    $this->assertContains('Sorry, your email or password was in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testLoginDoesNotValidateEmptyPassword() {
    $password = '';

    foreach (array_keys($GLOBALS['verified_users']) as $user) {
      $email = $GLOBALS['verified_users'][$user]['email'];

      UserManager::login($email, $password);

      $this->assertNotEmpty($GLOBALS['errors']);
      $this->assertContains('Please enter a valid password.', $GLOBALS['errors']);
      $this->assertContains('Sorry, your email or password was in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
    }
  }

  public function testLoginDoesNotValidateNonExistingEmail() {
    $email = $GLOBALS['nonexistent_email'];
    $password = $GLOBALS['valid_password'];

    UserManager::login($email, $password);

    $this->assertContains('Sorry, your email address was not found. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testVerifiedUsersAreLoggedIn() {
    $password = $GLOBALS['valid_password'];

    foreach (array_keys($GLOBALS['verified_users']) as $user) {
      // Record time login started (to check if within limit i.e. 10 seconds)
      $start_time = microtime(true);
      $time_limit = 10;

      $email = $GLOBALS['verified_users'][$user]['email'];

      UserManager::login($email, $password);

      $this->assertEquals($GLOBALS['verified_users'][$user]['id'], $_SESSION['user']->id);
      $this->assertEquals($GLOBALS['verified_users'][$user]['role_id'], $_SESSION['user']->role_id);
      $this->assertEquals(true, $_SESSION['user']->verified);

      // Check for patient-only details set in session
      if (strpos($user, 'patient') !== false) {
        $this->assertEquals($email, $_SESSION['user']->email);
        $this->assertEquals($GLOBALS['verified_users'][$user]['mob_no'], $_SESSION['user']->number);
        $this->assertNotNull($_SESSION['user']->contact_by_email);
        $this->assertNotNull($_SESSION['user']->contact_by_text);
      }

      // Check the time taken to log the user in
      $time_elapsed = microtime(true) - $start_time;

      $this->assertEmpty($GLOBALS['errors']);
      $this->assertTrue($time_elapsed < $time_limit);

      // Log out to destroy user sessions
      include dirname(__FILE__) . '/../../front-end/scripts/logout.php';
    }
  }

  public function testUnverifiedUsersAreNotLoggedIn() {
    $password = $GLOBALS['valid_password'];

    foreach (array_keys($GLOBALS['unverified_users']) as $user) {
      $email = $GLOBALS['unverified_users'][$user]['email'];

      UserManager::login($email, $password);

      $this->assertNotEmpty($GLOBALS['errors']);
      $this->assertContains('Sorry, your account is not yet verified. If you have any queries, please contact your medical facility.', $GLOBALS['errors']);
    }
  }

  public function testRegistrationDoesNotValidateExistingEmail() {
    $data['password'] = $GLOBALS['valid_password'];
    $data['patient'] = $GLOBALS['patient_filled'];
    $data['next_of_kin'] = $GLOBALS['nok_filled'];

    foreach (array_keys($GLOBALS['verified_users']) as $user) {
      $data['email'] = $GLOBALS['verified_users'][$user]['email'];

      UserManager::register($data);

      $this->assertNotEmpty($GLOBALS['errors']);
      $this->assertContains('Sorry, the email address you entered has already been taken. Please try again.', $GLOBALS['errors']);
    }
  }

  public function testRegistrationDoesNotValidateEmptyEmail() {
    $data = array(
      'email' => '',
      'password' => $GLOBALS['valid_password'],
      'patient' => $GLOBALS['patient_filled'],
      'next_of_kin' => $GLOBALS['nok_filled'],
    );

    UserManager::register($data);

    $this->assertNotEmpty($GLOBALS['errors']);
    $this->assertContains('Please enter a valid email address.', $GLOBALS['errors']);
    $this->assertContains('Sorry, your details were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testRegistrationDoesNotValidateEmptyPassword() {
    $data = array(
      'email' => $GLOBALS['new_email'],
      'password' => '',
      'patient' => $GLOBALS['patient_filled'],
      'next_of_kin' => $GLOBALS['nok_filled'],
    );

    UserManager::register($data);

    $this->assertNotEmpty($GLOBALS['errors']);
    $this->assertContains('Please enter a valid password.', $GLOBALS['errors']);
    $this->assertContains('Sorry, your details were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testRegistrationDoesNotValidateEmptyPatientDetails() {
    $data = array(
      'email' => $GLOBALS['new_email'],
      'password' => $GLOBALS['valid_password'],
      'patient' => $GLOBALS['patient_empty'],
      'next_of_kin' => $GLOBALS['nok_filled'],
    );

    UserManager::register($data);

    $this->assertNotEmpty($GLOBALS['errors']);
    $this->assertContains('Please enter a valid title', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid forename', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid surname', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid sex', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid date_of_birth', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid street', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid city', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid county', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid postcode', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid next_of_kin', $GLOBALS['errors']);
    $this->assertContains('Please enter either your mobile number or telephone number, or both.', $GLOBALS['errors']);
    $this->assertContains('Please enter either your NHS number or Health and Care number (Northern Ireland only).', $GLOBALS['errors']);
    $this->assertContains('Please enter either a house name or house number, or both.', $GLOBALS['errors']);
  }

  public function testRegistrationDoesNotValidateEmptyNextOfKinDetails() {
    $data = array(
      'email' => $GLOBALS['new_email'],
      'password' => $GLOBALS['valid_password'],
      'patient' => $GLOBALS['patient_filled'],
      'next_of_kin' => $GLOBALS['nok_empty'],
    );

    UserManager::register($data);

    $this->assertNotEmpty($GLOBALS['errors']);
    $this->assertContains('Please enter a valid relationship', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid title', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid forename', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid surname', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid street', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid city', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid county', $GLOBALS['errors']);
    $this->assertContains('Please enter a valid postcode', $GLOBALS['errors']);
    $this->assertContains('Please enter either your mobile number or telephone number, or both.', $GLOBALS['errors']);
    $this->assertContains('Please enter either a house name or house number, or both.', $GLOBALS['errors']);
  }

  public function testPatientsCanBeRetrieved() {
    $patients = UserManager::getPatients();

    $this->assertIsArray($patients);
    $this->assertNotEmpty($patients);

    foreach ($patients as $patient) {
      $this->assertNotNull($patient['id']);
      $this->assertNotNull($patient['email']);
      $this->assertNotNull($patient['verified']);
      $this->assertNotNull($patient['title']);
      $this->assertNotNull($patient['forename']);
      $this->assertNotNull($patient['surname']);
      $this->assertNotNull($patient['sex']);
      $this->assertNotNull($patient['date_of_birth']);
      $this->assertNotNull($patient['house_name'] ?? $patient['house_no']);
      $this->assertNotNull($patient['street']);
      $this->assertNotNull($patient['city']);
      $this->assertNotNull($patient['county']);
      $this->assertNotNull($patient['postcode']);
      $this->assertNotNull($patient['tel_no'] ?? $patient['mob_no']);
      $this->assertNotNull($patient['next_of_kin']);
      $this->assertNotNull($patient['NHS_no'] ?? $patient['HC_no']);
    }
  }

  public function testUnverifiedPatientCanBeVerified() {
    foreach (array_keys($GLOBALS['unverified_users']) as $user) {
      $id = $GLOBALS['unverified_users'][$user]['id'];

      UserManager::verifyPatient($id);

      $this->assertEmpty($GLOBALS['errors']);

      $selections = array(
        'id' => array(
          'comparison' => '=',
          'param' => ':id',
          'value' => $id,
        ),
      );

      $update_columns = array(
        'verified' => array(
          'param' => ':verified',
          'value' => false,
        ),
      );

      // Unverify the verified users for other tests
      $verify_result = $GLOBALS['app']->getDB()->updateWhere('account', $selections, $update_columns);
    }
  }

  public function testFacilityDetailsCanBeRetrievedForValidUserId() {
    foreach (array_keys($GLOBALS['verified_users']) as $user) {
      $facility = UserManager::getUserFacility($GLOBALS['verified_users'][$user]['id']);

      $this->assertIsArray($facility);
      $this->assertNotEmpty($facility);
      $this->assertNotNull($facility['name']);
      $this->assertNotNull($facility['building_name'] ?? $facility['building_no']);
      $this->assertNotNull($facility['street']);
      $this->assertNotNull($facility['city']);
      $this->assertNotNull($facility['county']);
      $this->assertNotNull($facility['postcode']);
      $this->assertNotNull($facility['tel_no']);
    }
  }

  public function testFacilityDetailsCannotBeRetrievedForInvalidUserId() {
    $facility = UserManager::getUserFacility('non-existent');

    $this->assertNull($facility);
    $this->assertContains('An unexpected error has occurred. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testEmailPreferenceCanBeUpdated() {
    $values = [true, false];
    $password = $GLOBALS['valid_password'];

    $patients = array(
      $GLOBALS['verified_users']['patient-1'],
      $GLOBALS['verified_users']['patient-2'],
    );

    foreach ($values as $value) {
      foreach (array_keys($patients) as $patient) {
        $email = $patients[$patient]['email'];

        UserManager::login($email, $password);
        UserManager::updateContactByEmail($patients[$patient]['id'], $value);

        $patient_selections = array(
          'id' => array(
            'comparison' => '=',
            'param' => ':id',
            'value' => $patients[$patient]['id'],
          ),
        );

        // Check value in patient table
        $email_value = $GLOBALS['app']->getDB()->selectOneWhere('patient', $patient_selections, ['contact_by_email']);

        $this->assertEquals((boolean) $email_value['contact_by_email'], $value);
        $this->assertEquals((boolean) $_SESSION['user']->contact_by_email, $value);

        $this->assertEmpty($GLOBALS['errors']);
        $this->assertNotEmpty($GLOBALS['successes']);
        $this->assertContains('Your contact preferences have been updated successfully.', $GLOBALS['successes']);

        // Log out to destroy user sessions
        include dirname(__FILE__) . '/../../front-end/scripts/logout.php';
      }
    }
  }

  public function testTextPreferenceCanBeUpdated() {
    $values = [true, false];
    $password = $GLOBALS['valid_password'];

    $patients = array(
      $GLOBALS['verified_users']['patient-1'],
      $GLOBALS['verified_users']['patient-2'],
    );

    foreach ($values as $value) {
      foreach (array_keys($patients) as $patient) {
        $email = $patients[$patient]['email'];

        UserManager::login($email, $password);
        UserManager::updateContactByText($patients[$patient]['id'], $value);

        $patient_selections = array(
          'id' => array(
            'comparison' => '=',
            'param' => ':id',
            'value' => $patients[$patient]['id'],
          ),
        );

        // Check value in patient table and session
        $text_value = $GLOBALS['app']->getDB()->selectOneWhere('patient', $patient_selections, ['contact_by_text']);

        $this->assertEquals((boolean) $text_value['contact_by_text'], $value);
        $this->assertEquals((boolean) $_SESSION['user']->contact_by_text, $value);

        // Check status messages
        $this->assertEmpty($GLOBALS['errors']);
        $this->assertNotEmpty($GLOBALS['successes']);
        $this->assertContains('Your contact preferences have been updated successfully.', $GLOBALS['successes']);

        // Log out to destroy user sessions
        include dirname(__FILE__) . '/../../front-end/scripts/logout.php';
      }
    }
  }
}
