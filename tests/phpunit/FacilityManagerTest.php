<?php

require 'data/FacilityTestData.php';

use PHPUnit\Framework\TestCase;

class FacilityManagerTest extends TestCase {
  public function testContactDetailsCanBeRetrieved() {
    foreach ($GLOBALS['example_facilities'] as $facility) {
      $details = FacilityManager::getContactDetails($facility['id']);

      $this->assertIsArray($details);
      $this->assertNotEmpty($details);
      $this->assertEquals($details['name'], $facility['name']);
      $this->assertEquals($details['building_name'], $facility['building_name']);
      $this->assertEquals($details['building_no'], $facility['building_no']);
      $this->assertEquals($details['street'], $facility['street']);
      $this->assertEquals($details['city'], $facility['city']);
      $this->assertEquals($details['county'], $facility['county']);
      $this->assertEquals($details['postcode'], $facility['postcode']);
      $this->assertEquals($details['tel_no'], $facility['tel_no']);
    }
  }
}
