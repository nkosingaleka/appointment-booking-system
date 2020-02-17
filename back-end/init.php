<?php

/**
 * Autoloads classes in /back-end/classes/.
 *
 * @param $class_ref
 * @return void
 */
function autoload_classes($class_ref) {
  // Isolate class name from namespace
  $class_ref_parts = explode('\\', $class_ref);
  $class_name = end($class_ref_parts);

  $class_url = dirname(__FILE__) . "/classes/$class_name.php";
  require_once $class_url;
}

spl_autoload_register('autoload_classes');

// @codeCoverageIgnoreStart
// Instantiate the application
$GLOBALS['app'] = new App();
// @codeCoverageIgnoreEnd

$GLOBALS['errors'] = array();
