<?php

require 'data/AvailabilityTestData.php';
require 'data/SlotTestData.php';

use PHPUnit\Framework\TestCase;

class AvailabilityManagerTest extends TestCase {
  public function setUp(): void {
    $GLOBALS['errors'] = array();
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

  public function testSlotsCanBeRetrieved() {
    $slots = AvailabilityManager::getSlots();

    $this->assertIsArray($slots);
    $this->assertNotEmpty($slots);

    foreach ($slots as $slot) {
      $this->assertNotNull($slot['id']);
      $this->assertNotNull($slot['start_time']);
      $this->assertNotNull($slot['end_time']);
      $this->assertNotNull($slot['reserved']);
    }

    $this->assertEmpty($GLOBALS['errors']);
  }

  public function testDuplicateAvailabilityCannotBeAdded() {
    for ($i = 1; $i <= 2; $i += 1) {
      $this->logMedicalStaffIn($i);

      // Check existing slots for each medical staff member
      $existing = $i == 1 ? $GLOBALS['existing_slots_two_weeks_ahead'] : $GLOBALS['existing_slots_next_week'];

      $data = array(
        'start_time' => $existing[0]['start_time'],
        'end_time' => $existing[array_key_last($existing)]['end_time'],
      );

      AvailabilityManager::addAvailability($data);

      $this->assertEmpty($GLOBALS['successes']);
      $this->assertNotEmpty($GLOBALS['errors']);
      $this->assertContains('Sorry, you have already added your availability for the specified times.', $GLOBALS['errors']);

      $this->logOut();
    }
  }

  public function testAvailabilityCannotBeAddedForLessThanFiveSlots() {
    for ($i = 1; $i <= 2; $i += 1) {
      $this->logMedicalStaffIn($i);

      // Check existing slots for each medical staff member
      $existing = $i == 1 ? $GLOBALS['existing_slots_two_weeks_ahead'] : $GLOBALS['existing_slots_next_week'];

      $data = array(
        'start_time' => $existing[0]['start_time'],
        'end_time' => $existing[0]['end_time'],
      );

      AvailabilityManager::addAvailability($data);

      $this->assertEmpty($GLOBALS['successes']);
      $this->assertNotEmpty($GLOBALS['errors']);
      $this->assertContains('Sorry, you must allow time for ' . MIN_SLOTS . ' or more slots for at least 10% to be reserved for emergency appointments.', $GLOBALS['errors']);

      $this->logOut();
    }
  }

  public function testAvailabilityCannotBeAddedForEmptyStartTime() {
    for ($i = 1; $i <= 2; $i += 1) {
      $this->logMedicalStaffIn($i);

      $data = array(
        'start_time' => '',
        'end_time' => date('Y-m-d', strtotime('monday +10 weeks')) . ' 09:10:00',
      );

      AvailabilityManager::addAvailability($data);

      $this->assertEmpty($GLOBALS['successes']);
      $this->assertNotEmpty($GLOBALS['errors']);
      $this->assertContains('Please enter a valid start time.', $GLOBALS['errors']);
      $this->assertContains('Sorry, your times were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);

      $this->logOut();
    }
  }

  public function testAvailabilityCannotBeAddedForEmptyEndTime() {
    for ($i = 1; $i <= 2; $i += 1) {
      $this->logMedicalStaffIn($i);

      $data = array(
        'start_time' => date('Y-m-d', strtotime('monday +10 weeks')) . ' 09:00:00',
        'end_time' => '',
      );

      AvailabilityManager::addAvailability($data);

      $this->assertEmpty($GLOBALS['successes']);
      $this->assertNotEmpty($GLOBALS['errors']);
      $this->assertContains('Please enter a valid end time.', $GLOBALS['errors']);
      $this->assertContains('Sorry, your times were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);

      $this->logOut();
    }
  }

  public function testAvailabilityCannotBeAddedForEndTimeBeforeStartTime() {
    for ($i = 1; $i <= 2; $i += 1) {
      $this->logMedicalStaffIn($i);

      $data = array(
        'start_time' => date('Y-m-d', strtotime('monday +10 weeks')) . ' 09:10:00',
        'end_time' => date('Y-m-d', strtotime('monday +10 weeks')) . ' 09:00:00',
      );

      AvailabilityManager::addAvailability($data);

      $this->assertEmpty($GLOBALS['successes']);
      $this->assertNotEmpty($GLOBALS['errors']);
      $this->assertContains('Please enter an end time after the start time.', $GLOBALS['errors']);
      $this->assertContains('Sorry, your times were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);

      $this->logOut();
    }
  }

  public function testAvailabilityCannotBeAddedForStartTimeInPast() {
    for ($i = 1; $i <= 2; $i += 1) {
      $this->logMedicalStaffIn($i);

      $data = array(
        'start_time' => date('Y-m-d', strtotime('yesterday')) . ' 23:00:00',
        'end_time' => date('Y-m-d', strtotime('today')) . ' 00:00:00',
      );

      AvailabilityManager::addAvailability($data);

      $this->assertEmpty($GLOBALS['successes']);
      $this->assertNotEmpty($GLOBALS['errors']);
      $this->assertContains('Please do not enter start and end times in the past.', $GLOBALS['errors']);
      $this->assertContains('Sorry, your times were in an incorrect format. Please check your input and try again.', $GLOBALS['errors']);

      $this->logOut();
    }
  }

  public function testAvailabilityCanBeRetrieved() {
    $staff = array(
      $GLOBALS['verified_users']['medical-1'],
      $GLOBALS['verified_users']['medical-2'],
    );

    for ($i = 1; $i <= 2; $i += 1) {
      $this->logMedicalStaffIn($i);

      // Check existing slots for each medical staff member
      $existing_slots = $i == 1 ? $GLOBALS['existing_slots_two_weeks_ahead'] : $GLOBALS['existing_slots_next_week'];

      // Check existing availabilities for each medical staff member
      $existing_availabilities = $i == 1 ? $GLOBALS['existing_availabilities_two_weeks_ahead'] : $GLOBALS['existing_availabilities_next_week'];

      for ($j = 0; $j < count($existing_availabilities); $j += 1) {
        for ($k = 0; $k < count($existing_slots); $k += 1) {
          $availability = AvailabilityManager::getAvailability($existing_slots[$j]['id'], $staff[$i - 1]['id']);

          $this->assertIsString($availability);
          $this->assertNotNull($availability);
          $this->assertEquals($availability, $existing_availabilities[$j]);

          $this->logOut();
        }
      }
    }
  }
}
