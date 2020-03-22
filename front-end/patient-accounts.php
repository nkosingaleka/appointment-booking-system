<?php

require_once '../back-end/init.php';

session_start();

// Checks for if the user is logged in and if necessary to redirect them to the login page
if (!isset($_SESSION['user'])) {
  $GLOBALS['app']->redirect('login.php');
} else {
  // Redirect people who are not admin staff
  if ($_SESSION['user']->role_id != ADMINISTRATIVE_ROLE) {
    $GLOBALS['app']->redirect('index.php');

  } else {
    $patients = UserManager::getPatients();
    $verified_patients = $unverified_patients = [];

    foreach ($patients as $patient) {
      if ($patient['verified']) {
        $verified_patients[] = $patient;
      } else {
        $unverified_patients[] = $patient;
      }
    }
  }
}

// Check if the administrative staff member provides a search query
if (isset($_GET['query']) && !empty($_GET['query'])) {
  $verified_patients = array_filter($verified_patients, function ($patient) {
    foreach ($patient as $detail) {
      if (strpos($detail, $_GET['query']) !== FALSE) {
        return true;
      }
    }
  });

  $unverified_patients = array_filter($unverified_patients, function ($patient) {
    foreach ($patient as $detail) {
      if (strpos($detail, $_GET['query']) !== FALSE) {
        return true;
      }
    }
  });
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$GLOBALS['app']->title?></title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

<?php include dirname(__FILE__) . '/../back-end/includes/header.inc.php';?>

  <main>
  <h2>User Accounts</h2>
    <?php include dirname(__FILE__) . '/../back-end/includes/error_container.inc.php';?>

    <form action="" method="GET">
      <label for="query">Search patients</label>
      <input type="search" name="query" id="query" value="<?=$_GET['query'] ?? ''?>" required>
      <input type="submit" id="search" value="Search">
    </form>

    <button id="verified-btn">Verified</button>
    <button id="unverified-btn">Unverified</button>

    <section id="verified-patients">
      <h2>Verified Patients</h2>

      <?php if (count($verified_patients) > 0): ?>
        <?php foreach ($verified_patients as $patient): ?>
          <article>
            <ul>
              <li>
                <b>ID:</b> <?=$patient['id']?>
              </li>
              <li>
                <b>Email address:</b> <?=$patient['email']?>
              </li>
              <li>
                <b>Full name:</b> <?=$patient['title'] . ' ' . $patient['forename'] . ' ' . $patient['surname']?>
              </li>
              <li>
                <b>Sex:</b> <?=$patient['sex']?>
              </li>
              <li>
                <b>Date of birth:</b> <?=$patient['date_of_birth']?>
              </li>
              <li>
                <b>Address:</b> <?=$patient['house_no'] ?? $patient['house_name'] . ' ' . $patient['street'] . ', ' . $patient['city'] . ', ' . $patient['county'] . ', ' . $patient['postcode']?>
              </li>

              <?php if (isset($patient['tel_no'])): ?>
                <li>
                  <b>Telephone Number:</b> <?=$patient['tel_no']?>
                </li>
              <?php endif?>

              <?php if (isset($patient['mob_no'])): ?>
                <li>
                  <b>Mobile Number:</b> <?=$patient['mob_no']?>
                </li>
              <?php endif?>

              <li>
                <b>Next of kin ID:</b> <?=$patient['next_of_kin']?>
              </li>

              <?php if (isset($patient['NHS_no'])): ?>
                <li>
                  <b>NHS Number:</b> <?=$patient['NHS_no']?>
                </li>
              <?php endif?>

              <?php if (isset($patient['HC_no'])): ?>
                <li>
                  <b>Health and Care Number:</b> <?=$patient['HC_no']?>
                </li>
              <?php endif?>
            </ul>
          </article>
        <?php endforeach?>
      <?php else: ?>
        <p>Sorry, no patients were found.</p>
      <?php endif?>
    </section>

    <section id="unverified-patients" class="hidden">
      <h2>Unverified Patients</h2>

      <?php if (count($unverified_patients) > 0): ?>
        <?php foreach ($unverified_patients as $patient): ?>
          <article>
            <ul>
              <li>
                <b>ID:</b> <?=$patient['id']?>
              </li>
              <li>
                <b>Email address:</b> <?=$patient['email']?>
              </li>
              <li>
                <b>Full name:</b> <?=$patient['title'] . ' ' . $patient['forename'] . ' ' . $patient['surname']?>
              </li>
              <li>
                <b>Sex:</b> <?=$patient['sex']?>
              </li>
              <li>
                <b>Date of birth:</b> <?=$patient['date_of_birth']?>
              </li>
              <li>
                <b>Address:</b> <?=$patient['house_no'] ?? $patient['house_name'] . ' ' . $patient['street'] . ', ' . $patient['city'] . ', ' . $patient['county'] . ', ' . $patient['postcode']?>
              </li>

              <?php if (isset($patient['tel_no'])): ?>
                <li>
                  <b>Telephone Number:</b> <?=$patient['tel_no']?>
                </li>
              <?php endif?>

              <?php if (isset($patient['mob_no'])): ?>
                <li>
                  <b>Mobile Number:</b> <?=$patient['mob_no']?>
                </li>
              <?php endif?>

              <li>
                <b>Next of kin ID:</b> <?=$patient['next_of_kin']?>
              </li>

              <?php if (isset($patient['NHS_no'])): ?>
                <li>
                  <b>NHS Number:</b> <?=$patient['NHS_no']?>
                </li>
              <?php endif?>

              <?php if (isset($patient['HC_no'])): ?>
                <li>
                  <b>Health and Care Number:</b> <?=$patient['HC_no']?>
                </li>
              <?php endif?>
            </ul>

            <a href="verify.php?id=<?=$patient['id']?>">Verify</a>
          </article>
        <?php endforeach?>
      <?php else: ?>
        <p>Sorry, no patients were found.</p>
      <?php endif?>
    </section>
  </main>

  <script src="js/patient-accounts.js"></script>
</body>
</html>
