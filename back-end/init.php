<?php

/**
 * Autoloads classes in /back-end/classes/.
 *
 * @param $class_ref
 * @return void
 */
function autoloadClasses($class_ref) {
  // Isolate class name from namespace
  $class_ref_parts = explode('\\', $class_ref);
  $class_name = end($class_ref_parts);

  $class_url = dirname(__FILE__) . "/classes/$class_name.php";
  
  if (file_exists($class_url)) {
    require_once $class_url;
  }
}

spl_autoload_register('autoloadClasses');

// Instantiate the application
$GLOBALS['app'] = new App();

// Add arrays for success and error messages
$GLOBALS['successes'] = array();
$GLOBALS['errors'] = array();

// Define user roles (administrative staff, medical staff, and patient)
define('ADMINISTRATIVE_ROLE', 1);
define('MEDICAL_ROLE', 2);
define('PATIENT_ROLE', 3);

// Define minimum number of slots that can be added by medical staff (10% of slots that rounds up to at least 1 slot)
define('MIN_SLOTS', 5);

// Define default slot duration in minutes and percentage multiplier of emergency slots
define('SLOT_LENGTH', 10);
define('RESERVED_SLOTS', 0.1);

// Define default date format (year-month-date hour:minute:second)
define('DATE_FORMAT', 'Y-m-d H:i:s');

// Define default timezone (United Kingdom)
date_default_timezone_set('Europe/London');

// Define default number of seconds to wait before refreshing pages
define('REFRESH_PERIOD', 3);
