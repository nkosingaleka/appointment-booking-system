<?php
require_once '../back-end/init.php';

session_start();

// Redirect users who are not already logged in to the login page
if (!isset($_SESSION['user'])) {
  $GLOBALS['app']->redirect('login.php');
} else {
  $page_title = 'Appointments';
  $to_load = '';

  // Load the relevant script for the type of user
  if ($_SESSION['user']->role_id == PATIENT_ROLE) {
    $to_load = 'patient';
    $page_title = "My $page_title";
  } elseif ($_SESSION['user']->role_id == MEDICAL_ROLE) {
    $to_load = 'medical';
  } else {
    $to_load = 'administrative';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$GLOBALS['app']->title?> &mdash; <?=$page_title?></title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php include dirname(__FILE__) . '/../back-end/includes/header.inc.php';?>

  <main>
    <h2><?=$page_title?></h2>

    <?php require dirname(__FILE__) . "/../back-end/includes/appointments/appointments-$to_load.inc.php";?>
  </main>

  <script src="js/appointments.js"></script>
</body>

</html>