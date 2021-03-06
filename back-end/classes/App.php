<?php

/**
 * Class for the App helper component.
 *
 * @category Helper Component
 */

/**
 * Represents generally the application's running as a whole.
 *
 * @access public
 */
class App {
  /**
   * Human-readable title for the application, displayed across its pages.
   *
   * @var string
   */
  public $title = 'Appointment Booking System';

  /**
   * PHP Data Object (PDO) for connecting to the database.
   *
   * @var object
   */
  private $__db;

  /**
   * Creates a new App using the given configuration parameters.
   * The configuration should, at minimum, include parameters for database creation.
   *
   * @return void
   */

  public function __construct() {
    $this->__startDatabase();
  }

  /**
   * Creates a new Database using the stored database configuration parameters.
   *
   * @return void
   */
  private function __startDatabase() {
    $this->__db = new Database();
  }

  /**
   * Redirects the user to the given path.
   *
   * @param $location
   * @return void
   */
  public function redirect($location) {
    header("Location: $location");
  }

  /**
   * Gets the database object instantiated upon initialisation.
   *
   * @return Database
   */
  public function getDB() {
    return $this->__db;
  }
}
