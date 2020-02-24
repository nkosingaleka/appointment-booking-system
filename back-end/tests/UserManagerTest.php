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
