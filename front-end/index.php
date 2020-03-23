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
  <title><?= $GLOBALS['app']->title ?></title>
</head>

<body>
  <?php include dirname(__FILE__) . '/../back-end/includes/header.inc.php'; ?>

  <main>
    <?php include dirname(__FILE__) . '/../back-end/includes/error-container.inc.php';?>

    <?php if ($_SESSION['user']->role_id == PATIENT_ROLE): ?>
      <h2>Requesting Appointments</h2>

      <ul>
        <li><a href="request-appointment.php">Request an appointment</a></li>
      </ul>

      <h2>View Appointments</h2>

      <ul>
        <li><a href="appointments.php">View booked appointments</a></li>
      </ul>
    <?php endif ?>

    <?php if ($_SESSION['user']->role_id == MEDICAL_ROLE): ?>
      <h2>Review Appointments And Requests</h2>

      <ul>
        <li><a href="appointments.php">View requested/booked appointments</a></li>
        <li><a href="requests.php">Review requested appointments</a></li>
      </ul>

      <h2>Add Slots To Availability</h2>

      <ul>
        <li><a href="add-availability.php">Add available slots</a></li>
      </ul>
    <?php endif ?>

    <?php if ($_SESSION['user']->role_id == ADMINISTRATIVE_ROLE): ?>
      <h2>Appointment Booking</h2>

      <ul>
        <li><a href="appointments.php">View requested/booked appointments</a></li>
        <li><a href="book-appointment.php">Book reviewed appointments</a></li>
      </ul>

      <h2>Verify Accounts</h2>

      <ul>
        <li><a href="patient-accounts.php">Verify patient accounts</a></li>
      </ul>
    <?php endif ?>
  </main>
</body>

</html>
