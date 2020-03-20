<?php

use PHPUnit\Framework\TestCase;

class AvailabilityManagerTest extends TestCase {
  public function setUp(): void {
    $GLOBALS['errors'] = array();
  }

  public function testSlotsCanBeRetrieved() {
    $slots = AvailabilityManager::getSlots();

    $this->assertIsArray($slots);
    $this->assertEmpty($GLOBALS['errors']);
  }
}
