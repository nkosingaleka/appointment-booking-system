<?php

require 'data/UserManagerTestData.php';

use PHPUnit\Framework\TestCase;

class UserManagerTest extends TestCase {
  public function setUp(): void {
    $GLOBALS['errors'] = array();
  }

  public function testLoginDoesNotValidateEmptyEmail() {
    $email = '';
    $password = 'invalid';

    UserManager::login($email, $password);

    $this->assertContains('Please enter a valid email address.', $GLOBALS['errors']);
    $this->assertContains('Sorry, your email or password was in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testLoginDoesNotValidateInvalidEmail() {
    $email = 'invalidEmail';
    $password = '';

    UserManager::login($email, $password);

    $this->assertContains('Please enter a valid email address.', $GLOBALS['errors']);
    $this->assertContains('Sorry, your email or password was in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testLoginDoesNotValidateEmptyPassword() {
    $email = $GLOBALS['email_valid'];
    $password = '';

    UserManager::login($email, $password);

    $this->assertContains('Please enter a valid password.', $GLOBALS['errors']);
    $this->assertContains('Sorry, your email or password was in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testLoginDoesNotValidateNonExistingEmail() {
    $email = 'nonexistent@invalid.com';
    $password = $GLOBALS['password_valid'];

    UserManager::login($email, $password);

    $this->assertContains('Sorry, your email address was not found. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testRegistrationDoesNotValidateExistingEmail() {
    // NOTE: Ensure email actually exists
    $data = array(
      'email' => $GLOBALS['email_valid'],
      'password' => $GLOBALS['password_valid'],
      'patient' => $GLOBALS['patient_filled'],
      'next_of_kin' => $GLOBALS['nok_filled'],
    );

    UserManager::register($data);

    $this->assertContains('Sorry, the email address you entered has already been taken. Please try again.', $GLOBALS['errors']);
  }

  public function testRegistrationDoesNotValidateEmptyEmail() {
    $data = array(
      'email' => '',
      'password' => $GLOBALS['password_valid'],
      'patient' => $GLOBALS['patient_filled'],
      'next_of_kin' => $GLOBALS['nok_filled'],
    );

    UserManager::register($data);

    $this->assertContains('Please enter a valid email address.', $GLOBALS['errors']);
    $this->assertContains('Sorry, your details were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testRegistrationDoesNotValidateEmptyPassword() {
    $data = array(
      'email' => 'new@test.com',
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
      'email' => 'new@test.com',
      'password' => $GLOBALS['password_valid'],
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
      'email' => 'new@test.com',
      'password' => $GLOBALS['password_valid'],
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
