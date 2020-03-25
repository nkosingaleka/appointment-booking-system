<?php

use PHPUnit\Framework\TestCase;

class AppTest extends TestCase {
  public function testAppHasTitleProperty() {
    $app = new App();

    $this->assertIsString($app->title);
    $this->assertEquals($app->title, 'Appointment Booking System');

    $app = null;
  }

  public function testDatabaseCanBeCreated() {
    $app = new App();
    $db = $app->getDB();

    $this->assertIsObject($db);

    $app = null;
  }

  public function testRedirect() {
    $app = new App();
    $app->redirect('index.php');

    $this->assertFalse(headers_sent());

    $app = null;
  }
}
