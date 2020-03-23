<?php

require_once '../back-end/init.php';

session_start();

// Redirects users who are not logged in to the login page
if (!isset($_SESSION['user'])) {
  $GLOBALS['app']->redirect('login.php');
}

// Retrieve the account details of the current user
$account = UserManager::getAccount($_SESSION['user']->id);

// Retrieve details about the current user's facility
$facility = FacilityManager::getContactDetails('fa-5e4a83211ffd59.63214101');

// Check if contact preferences are updated
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Set the user's email messaging preference
  if (isset($_POST['contact_by_email'])) {
    UserManager::updateContactByEmail($_SESSION['user']->id, true);
  } elseif (!isset($_POST['contact_by_email'])) {
    UserManager::updateContactByEmail($_SESSION['user']->id, false);
  }

  // Set the user's text messaging preference
  if (isset($_POST['contact_by_text'])) {
    UserManager::updateContactByText($_SESSION['user']->id, true);
  } elseif (!isset($_POST['contact_by_text'])) {
    UserManager::updateContactByText($_SESSION['user']->id, false);
  }

  // Refresh the page
  header('Refresh:' . REFRESH_PERIOD);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include dirname(__FILE__) . '/../back-end/includes/head-elements.inc.php';?>
  <title><?=$GLOBALS['app']->title?> &mdash; My Account</title>
</head>

<body>

<?php include dirname(__FILE__) . '/../back-end/includes/header.inc.php';?>

  <main>
    <?php include dirname(__FILE__) . '/../back-end/includes/error-container.inc.php';?>
    <?php include dirname(__FILE__) . '/../back-end/includes/success-container.inc.php';?>

    <h2>My Account</h2>

    <?php if (!empty($account)): ?>
      <h3>Personal Details</h3>

      <ul>
        <li>
          <b>Email address:</b> <?=$account['email']?>
        </li>
        <li>
          <b>Full name:</b> <?=$account['full_name']?>
        </li>
        <li>
          <b>Sex:</b> <?=$account['sex']?>
        </li>

        <?php if (isset($account['date_of_birth'])): ?>
          <li>
            <b>Date of birth:</b> <?=$account['date_of_birth']?>
          </li>
        <?php endif?>

        <?php if (isset($account['job_title'])): ?>
          <li>
            <b>Role:</b> <?=$account['job_title']?>
          </li>
        <?php endif?>

        <?php if (isset($account['address'])): ?>
          <li>
            <b>Address:</b> <?=$account['address']?>
          </li>
        <?php endif?>

        <?php if (isset($account['tel_no'])): ?>
          <li>
            <b>Telephone number:</b> <?=$account['tel_no']?>
          </li>
        <?php endif?>

        <?php if (isset($account['mob_no'])): ?>
          <li>
            <b>Mobile number:</b> <?=$account['mob_no']?>
          </li>
        <?php endif?>

        <?php if (isset($account['nhs_no'])): ?>
          <li>
            <b>NHS number:</b> <?=$account['nhs_no']?>
          </li>
        <?php endif?>

        <?php if (isset($account['hc_no'])): ?>
          <li>
            <b>Health and Care number:</b> <?=$account['hc_no']?>
          </li>
        <?php endif?>
      </ul>
    <?php endif?>

    <?php if (count($facility) > 0): ?>
      <h3>Facility Details</h3>

      <ul>
        <li>
          <b>Name:</b> <?=$facility['name']?>
        </li>
        <li>
          <b>Address:</b> <?=$facility['building_name'] ?? $facility['building_no'] . ', ' . $facility['street'] . ', ' . $facility['city'] . ', ' . $facility['county'] . ', ' . $facility['postcode']?>
        </li>
        <li>
          <b>Telephone number:</b> <?=$facility['tel_no']?>
        </li>
      </ul>
    <?php endif?>

    <?php if ($account['role'] == PATIENT_ROLE): ?>
      <h3>Contact Preferences</h3>

      <p>Please check at least one of the following to set your contact preferences.</p>

      <form id="preferences-form" action="" method="POST">
        <span>I would like to be contacted via&hellip;</span>

        <label for="contact_by_email">
          <input type="checkbox" name="contact_by_email" id="contact_by_email" <?=$account['contact_by_email'] || isset($_POST['contact_by_email']) ? 'checked' : ''?>>
          Email
        </label>

        <label for="contact_by_text">
          <input type="checkbox" name="contact_by_text" id="contact_by_text" <?=$account['contact_by_text'] || isset($_POST['contact_by_text']) ? 'checked' : ''?>>
          Text (SMS)
        </label>

        <input type="submit" name="update-preferences" id="update-preferences" value="Update Preferences">
      </form>
    <?php endif?>
  </main>

  <a aria-label="Help" class="btn help-btn" href="help.php">?</a>

</body>
</html>
