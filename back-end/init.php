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

$GLOBALS['errors'] = array();

// Define user roles (administrative staff, medical staff, and patient)
define('ADMINISTRATIVE_ROLE', 1);
define('MEDICAL_ROLE', 2);
define('PATIENT_ROLE', 3);
