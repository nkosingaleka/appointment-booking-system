<?php
require_once '../back-end/init.php';

session_start();

// Redirect users who are not already logged in to the login page
if (!isset($_SESSION['user'])) {
  $GLOBALS['app']->redirect('login.php');
} else {
  // Redirect users who are not patients
  if ($_SESSION['user']->role_id != PATIENT_ROLE) {
    $GLOBALS['app']->redirect('index.php');
  }
}

// Retrieve language options
$languages = $GLOBALS['app']
  ->getDB()->selectJoin('facility_language', 'language', 'facility_language.language_id = language.id', ['language.id', 'name']);

$staff_selections = array(
  'role_id' => array(
    'comparison' => '=',
    'param' => ':role_id',
    'value' => MEDICAL_ROLE,
  ),
);

$staff_projections = array('staff.id', 'title', 'forename', 'surname');

// Retrieve staff
$staff = $GLOBALS['app']->getDB()->selectJoinWhere('staff', 'account', 'account.id = staff.id', $staff_selections, $staff_projections);

// Check if the request form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['appointment_reason'], $_POST['translation_choice'], $_POST['staff_choice'], $_GET['slots'])) {
    // Sanitise the user's preferences
    $sanitise = function ($item) {
      return trim(htmlspecialchars($item));
    };

    $data = array(
      'patient_id' => $_SESSION['user']->id,
      'appointment_reason' => $_POST['appointment_reason'],
      'translation_choice' => $_POST['translation_choice'],
      'staff_choice' => $_POST['staff_choice'],
    );

    array_map($sanitise, $data);
    $data['slots'] = array_map($sanitise, $_GET['slots']);

    RequestManager::makeRequest($data);
  } else {
    $GLOBALS['errors'][] = 'Please enter all required fields and select at least one time slot.';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$GLOBALS['app']->title ?> &mdash; Request Appointment</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php include dirname(__FILE__) . '/../back-end/includes/header.inc.php'; ?>

  <main>
    <?php include dirname(__FILE__) . '/../back-end/includes/error_container.inc.php'; ?>

    <div id = "request-section">
      <h2>Request Appointment</h2>

      <form method="post" id="request-form">
      <label for="period_choice">
        Period
        <select name="period_choice" id="period_choice">
        </select>
      </label>

      <label for="appointment_reason">
        Reason (optional)
        <textarea name="appointment_reason" id="appointment_reason"><?= isset($_POST['appointment_reason']) ? $_POST['appointment_reason'] : '' ?></textarea>
      </label>

      <label for="translation_choice">
        Translation required
        <select name="translation_choice" id="translation_choice" required>
          <option value="none" selected>None (English)</option>
          <?php if (count($languages) > 0): ?>
            <?php foreach ($languages as $language): ?>
              <option value="<?=$language['id']?>"><?=$language['name']?></option>
            <?php endforeach?>
          <?php endif?>
          <option value="other">Other</option>
        </select>
      </label>

      <label for="staff_choice">
        Preferred Staff
        <select name="staff_choice" id="staff_choice" required>
          <option value="">Choose Staff</option>
          <?php if (count($staff) > 0): ?>
            <?php foreach ($staff as $member): ?>
              <option value="<?=$member['id'] ?>"><?="{$member['title']} {$member['forename']} {$member['surname']}" ?></option>
            <?php endforeach ?>
          <?php endif ?>
        </select>
      </label>

      <input name="confirm" id="confirm" type="submit" value="Confirm">
    </form>

    <div id="slots-table">
    </div>
  </div>
  </main>

  <script src="js/request-appointment.js"></script>
</body>

</html>
