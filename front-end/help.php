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
  <title><?=$GLOBALS['app']->title?> &mdash; Help</title>
</head>

<body>
  <?php include dirname(__FILE__) . '/../back-end/includes/header.inc.php';?>
<h3></h3>
<p></p>
  <main>
    <?php if ($_SESSION['user']->role_id == PATIENT_ROLE): ?>
      <h2>Patient</h2>
        <h3>Viewing Account Details</h3>
        <p>To view personal details, go to {account.php}. On this page, you can view all of your personal details that you inputted when registering your account and can update your contact preferences be it email, text (SMS) or both.</p>
        <h3>Requesting an Appointment</h3>
        <p>To request an appointment, go to {request-appointment.php}. On this page, you can select up to 5 preferred time slots up to 3 weeks in advance and specify the reason for the appointment, whether you need a translator, and your preferred member of staff.</p>
        <h3>Viewing Requests</h3>
        <p>To view requests you have made, go to {requests.php}. On this page, you can view the date, time, staff member, reason, translation (if required) and appointment type.</p>
        <h3> Cancelling Requests</h3>
        <p>To cancel requests you have made, go to {requests.php}. On this page, you can select the ‘cancel’ button, a confirm cancellation appears with an optional cancellation reason, you will receive a confirmation message via email or text (SMS) depending on the preference you had chosen.</p>
        <h3>Viewing Appointments</h3>
        <p>To cancel your booked appointments, go to {appointments.php}. On this page, you can select the ‘cancel’ button, a confirmation appears with an optional cancellation reason, you will receive a confirmation message via email or text (SMS) depending on the preference you had chosen.</p>
        <h3>Cancelling Appointments</h3>
        <p>To cancel your booked appointments, go to {appointments.php}. On this page, you can select the ‘cancel’ button, a confirmation appears with an optional cancellation reason, you will receive a confirmation message via email or text (SMS) depending on the preference you had chosen.</p>
    <?php endif?>

    <?php if ($_SESSION['user']->role_id == MEDICAL_ROLE): ?>
      <h2>Medical Staff</h2>
        <h3>Viewing Account Details</h3>
        <p>To view personal details, go to {account.php}. On this page, you can view all of your personal details that you inputted when joining.</p>
        <h3>Viewing Requests</h3>
        <p>To view requests for appointments, go to {requests.php}. On this page, you can view the date, time, staff member, reason, translation (if required) and appointment type.</p>
        <h3>Cancelling Requests</h3>
        <p>To cancel requests for appointments, go to {requests.php}. On this page, you can select the ‘cancel’ button, a confirm cancellation appears with an optional cancellation reason, the patient will receive a confirmation message via email or text (SMS) depending on the preference you had chosen.</p>
        <h3>Reviewing Requests</h3>
        <p>To set the appointment type needed for a requested appointment, go to {requests.php}. On this page, you can set the appointment type based on the reason, whether the appointment should be a routine or an emergency.</p>
        <h3>Adding Availability </h3>
        <p>To add your availability, go to {add-availability.php}. On this page, you can add your start time and end time of your working hours.</p>
        <h3>Viewing Appointments</h3>
        <p>To view appointments booked with you, go to {appointments.php}. On this page, you can view the date, time, reason, translation (if required) and appointment type.</p>
        <h3>Cancelling Appointments</h3>
        <p>To cancel appointments booked with you, go to {appointments.php}. On this page, you can select the ‘cancel’ button, a confirmation appears with an optional cancellation reason, the patient will receive a confirmation message via email or text (SMS) depending on the preference they had chosen.</p>
        
    <?php endif?>

    <?php if ($_SESSION['user']->role_id == ADMINISTRATIVE_ROLE): ?>
      <h2>Administrative Staff</h2>
        <h3>Viewing Account Details</h3>
        <p>To view personal details, go to {account.php}. On this page, you can view all of your personal details that you inputted when joining.</p>
        <h3>Viewing Requests</h3>
        <p>To view requests for appointments, go to {requests.php}. On this page, you can view the date, time, staff member, reason, translation (if required) and appointment type.</p>
        <h3>Cancelling Requests</h3>
        <p>To cancel requests for appointments, go to {requests.php}. On this page, you can select the ‘cancel’ button, a confirmation appears with an optional cancellation reason, the patient will receive a confirmation message via email or text (SMS) depending on the preference they had chosen. </p>
        <h3>Viewing Appointments</h3>
        <p>To view booked appointments, go to {appointments.php}. On this page, you can view the date, time, reason, translation (if required) and appointment type.</p>
        <h3>Cancelling Appointments</h3>
        <p>To cancel booked appointments, go to {appointments.php}. On this page, you can select the ‘cancel’ button, a confirmation appears with an optional cancellation reason, the patient will receive a confirmation message via email or text (SMS) depending on the preference they had chosen.</p>
        <h3>Booking Appointments</h3>
        <p>To book appointments, go to {requests.php}. On this page, you can view all the current appointment requests made, the ‘book’ button will direct you to a new page to continue with the selected booking request. The patient’s request details will be displayed underneath the period and staff which you can choose based on the patient’s preferability</p> 
    <?php endif?>
  </main>
</body>

</html>
