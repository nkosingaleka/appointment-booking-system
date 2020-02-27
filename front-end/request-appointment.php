<?php
require_once '../back-end/init.php';

session_start();

// Redirect users who are not already logged in to the login page
if (!isset($_SESSION['user'])) {
  $GLOBALS['app']->redirect('login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$GLOBALS['app']->title?> &mdash; Request Appointment</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php include dirname(__FILE__) . '/../back-end/includes/header.inc.php';?>

  <main>
    <?php include dirname(__FILE__) . '/../back-end/includes/error_container.inc.php';?>

    <form method="post" id="request-form">
      <label for="email">
        Email Address
        <input type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>"
          required>
      </label>

      <label for="period_choice">
        Period
        <select name="period_choice" id="period_choice" required>
          <option value="">Choose period</option>
        </select>
      </label>

      <label for="appointment_reason">
        Reason (optional)
        <textarea name="appointment_reason" id="appointment_reason"></textarea>
      </label>

      <label for="translation_choice">
        Translation required
        <select name="translation_choice" id="translation_choice" required>
          <option value="">Choose Language</option>
          <option value="">No (English)</option>
        </select>
      </label>

      <label for="staff_choice">
        Preffered Staff
        <select name="staff_choice" id="staff_choice" required>
          <option value="">Choose Staff</option>
          <option value="">Dr Pepper </option>
          <option value="">Dr Strange</option>
          <option value="">Dr Who</option>
        </select>
      </label>
    </form>
  </main>
</body>

</html>