<?php

require_once '../back-end/init.php';

session_start();

// Redirects users who are not logged in to the login page
if (!isset($_SESSION['user'])) {
  $GLOBALS['app']->redirect('login.php');
}

// Retrieve the account details of the current user
$account = UserManager::getAccount($_SESSION['user']->id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$GLOBALS['app']->title?> &mdash; My Account</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

<?php include dirname(__FILE__) . '/../back-end/includes/header.inc.php';?>

  <main>
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
            <b>Telephone Number:</b> <?=$account['tel_no']?>
          </li>
        <?php endif?>

        <?php if (isset($account['mob_no'])): ?>
          <li>
            <b>Mobile Number:</b> <?=$account['mob_no']?>
          </li>
        <?php endif?>

        <?php if (isset($account['nhs_no'])): ?>
          <li>
            <b>NHS Number:</b> <?=$account['nhs_no']?>
          </li>
        <?php endif?>

        <?php if (isset($account['hc_no'])): ?>
          <li>
            <b>Health and Care Number:</b> <?=$account['hc_no']?>
          </li>
        <?php endif?>
      </ul>
    <?php endif?>
  </main>
</body>
</html>
