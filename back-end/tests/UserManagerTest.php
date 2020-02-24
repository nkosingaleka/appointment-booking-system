<?php

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
    $email = 'as1@test.com';
    $password = '';

    UserManager::login($email, $password);

    $this->assertContains('Please enter a valid password.', $GLOBALS['errors']);
    $this->assertContains('Sorry, your email or password was in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testLoginDoesNotValidateNonExistingEmail() {
    $email = 'nonexistent@invalid.com';
    $password = 'test123';

    UserManager::login($email, $password);

    $this->assertContains('Sorry, your email address was not found. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testRegistrationDoesNotValidateExistingEmail() {
    // NOTE: Ensure email actually exists
    $data = array(
      'email' => 'as1@test.com',
      'password' => 'test123',
      'patient' => array(
        'title' => 'Mr',
        'forename' => 'David',
        'surname' => 'Bowden',
        'sex' => 'M',
        'date_of_birth' => '1990-01-26',
        'house_name' => '',
        'house_no' => '12',
        'street' => 'Meyrick Road',
        'city' => 'Portsmouth',
        'county' => 'Hampshire',
        'postcode' => 'PO2 RJF',
        'tel_no' => '+447691014037',
        'mob_no' => '+448865738896',
        'next_of_kin' => 'nk-5e4693079a5e18.63580261',
        'nhs_no' => '4562594365',
        'hc_no' => '',
      ),
      'next_of_kin' => array(
        'relationship' => 'Father',
        'title' => 'Mr',
        'forename' => 'Nerti',
        'surname' => 'Philson',
        'house_name' => '',
        'house_no' => '7',
        'street' => 'London Road',
        'city' => 'Southampton',
        'county' => 'Hampshire',
        'postcode' => 'SO15 2AE',
        'tel_no' => '+447691014037',
        'mob_no' => '+448865738896',
      ),
    );

    UserManager::register($data);

    $this->assertContains('Sorry, the email address you entered has already been taken. Please try again.', $GLOBALS['errors']);
  }

  public function testRegistrationDoesNotValidateEmptyEmail() {
    $data = array(
      'email' => '',
      'password' => 'test123',
      'patient' => array(
        'title' => 'Mr',
        'forename' => 'David',
        'surname' => 'Bowden',
        'sex' => 'M',
        'date_of_birth' => '1990-01-26',
        'house_name' => '',
        'house_no' => '12',
        'street' => 'Meyrick Road',
        'city' => 'Portsmouth',
        'county' => 'Hampshire',
        'postcode' => 'PO2 RJF',
        'tel_no' => '+447691014037',
        'mob_no' => '+448865738896',
        'next_of_kin' => 'nk-5e4693079a5e18.63580261',
        'nhs_no' => '4562594365',
        'hc_no' => '',
      ),
      'next_of_kin' => array(
        'relationship' => 'Father',
        'title' => 'Mr',
        'forename' => 'Nerti',
        'surname' => 'Philson',
        'house_name' => '',
        'house_no' => '7',
        'street' => 'London Road',
        'city' => 'Southampton',
        'county' => 'Hampshire',
        'postcode' => 'SO15 2AE',
        'tel_no' => '+447691014037',
        'mob_no' => '+448865738896',
      ),
    );

    UserManager::register($data);

    $this->assertContains('Please enter a valid email address.', $GLOBALS['errors']);
    $this->assertContains('Sorry, your details were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testRegistrationDoesNotValidateEmptyPassword() {
    $data = array(
      'email' => 'new@test.com',
      'password' => '',
      'patient' => array(
        'title' => 'Mr',
        'forename' => 'David',
        'surname' => 'Bowden',
        'sex' => 'M',
        'date_of_birth' => '1990-01-26',
        'house_name' => '',
        'house_no' => '12',
        'street' => 'Meyrick Road',
        'city' => 'Portsmouth',
        'county' => 'Hampshire',
        'postcode' => 'PO2 RJF',
        'tel_no' => '+447691014037',
        'mob_no' => '+448865738896',
        'next_of_kin' => 'nk-5e4693079a5e18.63580261',
        'nhs_no' => '4562594365',
        'hc_no' => '',
      ),
      'next_of_kin' => array(
        'relationship' => 'Father',
        'title' => 'Mr',
        'forename' => 'Nerti',
        'surname' => 'Philson',
        'house_name' => '',
        'house_no' => '7',
        'street' => 'London Road',
        'city' => 'Southampton',
        'county' => 'Hampshire',
        'postcode' => 'SO15 2AE',
        'tel_no' => '+447691014037',
        'mob_no' => '+448865738896',
      ),
    );

    UserManager::register($data);

    $this->assertContains('Please enter a valid password.', $GLOBALS['errors']);
    $this->assertContains('Sorry, your details were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);
  }

  public function testRegistrationDoesNotValidateEmptyPatientDetails() {
    $data = array(
      'email' => 'new@test.com',
      'password' => 'test123',
      'patient' => array(
        'title' => '',
        'forename' => '',
        'surname' => '',
        'sex' => '',
        'date_of_birth' => '',
        'house_name' => '',
        'house_no' => '',
        'street' => '',
        'city' => '',
        'county' => '',
        'postcode' => '',
        'tel_no' => '',
        'mob_no' => '',
        'next_of_kin' => '',
        'nhs_no' => '',
        'hc_no' => '',
      ),
      'next_of_kin' => array(
        'relationship' => 'Father',
        'title' => 'Mr',
        'forename' => 'Nerti',
        'surname' => 'Philson',
        'house_name' => '',
        'house_no' => '7',
        'street' => 'London Road',
        'city' => 'Southampton',
        'county' => 'Hampshire',
        'postcode' => 'SO15 2AE',
        'tel_no' => '+447691014037',
        'mob_no' => '+448865738896',
      ),
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
      'password' => 'test123',
      'patient' => array(
        'title' => 'Mr',
        'forename' => 'David',
        'surname' => 'Bowden',
        'sex' => 'M',
        'date_of_birth' => '1990-01-26',
        'house_name' => '',
        'house_no' => '12',
        'street' => 'Meyrick Road',
        'city' => 'Portsmouth',
        'county' => 'Hampshire',
        'postcode' => 'PO2 RJF',
        'tel_no' => '+447691014037',
        'mob_no' => '+448865738896',
        'next_of_kin' => 'nk-5e4693079a5e18.63580261',
        'nhs_no' => '4562594365',
        'hc_no' => '',
      ),
      'next_of_kin' => array(
        'relationship' => '',
        'title' => '',
        'forename' => '',
        'surname' => '',
        'house_name' => '',
        'house_no' => '',
        'street' => '',
        'city' => '',
        'county' => '',
        'postcode' => '',
        'tel_no' => '',
        'mob_no' => '',
      ),
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
