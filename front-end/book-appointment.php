<?php
require_once '../back-end/init.php';

session_start();

// Redirect users who are not already logged in to the login page
if (!isset($_SESSION['user'])) {
  $GLOBALS['app']->redirect('login.php');
} else {
  // Redirect users who are not administrative staff
  if ($_SESSION['user']->role_id != ADMINISTRATIVE_ROLE) {
    $GLOBALS['app']->redirect('index.php');
  }
}

// Check if an approved appointment booking request has been selected
if (isset($_GET['request_id']) && !empty($_GET['request_id'])) {
  $request = RequestManager::getRequest($_GET['request_id']);

  // Check if request has been approved by a medical staff member
  if (!isset($request['appointment_type'])) {
    $GLOBALS['errors'][] = 'Please select a request that has been approved by a medical staff member.';
  }
} else {
  $GLOBALS['errors'][] = 'Please select a request before opening this page.';
}

// Define staff conditions to be checked in query
$staff_selections = array(
  'role_id' => array(
    'comparison' => '=',
    'param' => ':role_id',
    'value' => MEDICAL_ROLE,
  ),
);

// Define staff attributes to select
$staff_projections = array('staff.id', 'title', 'forename', 'surname');

// Retrieve staff
$staff = $GLOBALS['app']->getDB()->selectJoinWhere('staff', ['account'], ['account.id = staff.id'], $staff_selections, $staff_projections);

// Check if the request form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['staff_choice'], $_GET['slot'])) {
    $slot_id = trim(htmlspecialchars($_GET['slot']));

    $data = array(
      'booker_id' => $_SESSION['user']->id,
      'patient_id' => $request['patient_id'],
      'contact_by_email' => $request['contact_by_email'],
      'contact_by_text' => $request['contact_by_text'],
      'request_id' => trim(htmlspecialchars($_GET['request_id'])),
      'availability_id' => AvailabilityManager::getAvailability($slot_id, $_POST['staff_choice']),
    );

    BookingManager::bookAppointment($data);

  } else {
    $GLOBALS['errors'][] = 'Please select a medical staff member and time slot.';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include dirname(__FILE__) . '/../back-end/includes/head-elements.inc.php';?>
  <title><?=$GLOBALS['app']->title?> &mdash; Book Appointment</title>
</head>

<body>
  <?php include dirname(__FILE__) . '/../back-end/includes/header.inc.php';?>

  <main>
    <?php include dirname(__FILE__) . '/../back-end/includes/error-container.inc.php';?>
    <?php include dirname(__FILE__) . '/../back-end/includes/success-container.inc.php';?>

    <?php if (isset($_GET['request_id']) && !empty($_GET['request_id'])): ?>
      <div id="booking-section">
        <h2>Book Appointment</h2>

        <form action="" method="post" id="booking-form">
          <label for="period_choice">
            Period
            <select name="period_choice" id="period_choice">
            </select>
          </label>

          <label for="staff_choice">
            Staff
            <select name="staff_choice" id="staff_choice" required>
              <option value="">Choose Staff</option>
              <?php if (count($staff) > 0): ?>
                <?php foreach ($staff as $member): ?>
                  <option value="<?=$member['id']?>"><?="{$member['title']} {$member['forename']} {$member['surname']}"?></option>
                <?php endforeach?>
              <?php endif?>
            </select>
          </label>

          <ul>
            <li><b>Patient:</b> <?=$request['patient']?></li>
            <li><b>Translation required:</b> <?=$request['translation']?></li>
            <li><b>Preferred staff:</b> <?=$request['staff']?></li>
            <li><b>Preferred slots:</b></li>
            <ul>
              <?php foreach ($request['slots'] as $slot): ?>
                <li><?=date('D d/m/Y H:i', strtotime($slot['start_time']))?> &ndash; <?=substr(explode(' ', $slot['end_time'])[1], 0, -3)?></li>
              <?php endforeach?>
            </ul>
            <li><b>Appointment needed:</b> <?=ucfirst($request['appointment_type_title'])?></li>
          </ul>

          <input name="confirm" id="confirm" type="submit" value="Confirm">
        </form>

        <div id="slots-table">
        </div>
      </div>
    <?php endif?>
  </main>

  <script src="js/book-appointment.js"></script>
</body>

</html>
