<?php

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

    $this->assertContains('Please enter a valid email address.', $GLOBALS['errors']);
    $this->assertContains('Sorry, your email or password was in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testLoginDoesNotValidateInvalidEmail() {
    $email = $GLOBALS['invalid_email'];
    $password = '';

    UserManager::login($email, $password);

    $this->assertContains('Please enter a valid email address.', $GLOBALS['errors']);
    $this->assertContains('Sorry, your email or password was in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testLoginDoesNotValidateEmptyPassword() {
    $password = '';

    foreach (array_keys($GLOBALS['verified_users']) as $user) {
      $email = $GLOBALS['verified_users'][$user]['email'];

      UserManager::login($email, $password);

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
      $email = $GLOBALS['verified_users'][$user]['email'];

      UserManager::login($email, $password);

      $this->assertEquals($GLOBALS['verified_users'][$user]['id'], $_SESSION['user']->id);
      $this->assertEquals($GLOBALS['verified_users'][$user]['role_id'], $_SESSION['user']->role_id);
      $this->assertEquals(true, $_SESSION['user']->verified);

      $this->assertEmpty($GLOBALS['errors']);

      // Log out to destroy user sessions
      include dirname(__FILE__) . '/../../front-end/scripts/logout.php';
    }
  }

  public function testRegistrationDoesNotValidateExistingEmail() {
    $data['password'] = $GLOBALS['valid_password'];
    $data['patient'] = $GLOBALS['patient_filled'];
    $data['next_of_kin'] = $GLOBALS['nok_filled'];

    foreach (array_keys($GLOBALS['verified_users']) as $user) {
      $data['email'] = $GLOBALS['verified_users'][$user]['email'];

      UserManager::register($data);

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
}
