<?php
require_once '../back-end/init.php';

session_start();

// Redirect users who have not logged in to the login page
if (!isset($_SESSION['user'])) {
  $GLOBALS['app']->redirect('login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include dirname(__FILE__) . '/../back-end/includes/head-elements.inc.php';?>
  <title><?=$GLOBALS['app']->title?></title>
</head>

<body>
  <?php include dirname(__FILE__) . '/../back-end/includes/header.inc.php';?>

  <main>
    <?php if ($_SESSION['user']->role_id == PATIENT_ROLE): ?>
      <h2>Appointment Booking</h2>

      <ul>
        <li><a href="request-appointment.php">Request an appointment</a></li>
        <li><a href="requests.php">View your appointment booking requests</a></li>
        <li><a href="appointments.php">View your booked appointments</a></li>
      </ul>
    <?php endif?>

    <?php if ($_SESSION['user']->role_id == MEDICAL_ROLE): ?>
      <h2>Add Bookable Slots (Specify Availability)</h2>

      <ul>
        <li><a href="add-availability.php">Add available slots</a></li>
        <li><a href="request-appointment.php">View all available slots</a></li>
      </ul>

      <h2>Appointment Bookings</h2>

      <ul>
        <li><a href="requests.php">View your appointment booking requests</a></li>
        <li><a href="appointments.php">View your booked appointments</a></li>
      </ul>
    <?php endif?>

    <?php if ($_SESSION['user']->role_id == ADMINISTRATIVE_ROLE): ?>
      <h2>Account Verification</h2>

      <ul>
        <li><a href="patient-accounts.php">Verify patient accounts</a></li>
      </ul>

      <h2>Appointment Bookings</h2>

      <ul>
        <li><a href="request-appointment.php">View all available slots</a></li>
        <li><a href="requests.php">View appointment booking requests</a></li>
        <li><a href="appointments.php">View booked appointments</a></li>
      </ul>
    <?php endif?>
  </main>

  <a aria-label="Help" class="btn help-btn" href="help.php">?</a>
</body>

</html>
