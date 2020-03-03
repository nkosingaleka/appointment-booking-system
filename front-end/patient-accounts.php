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

    <button id="verified-btn">Verified</button>
    <button id="unverified-btn">Unverified</button>

    <section id="verified-patients">
      <h2>Verified Patients</h2>
      <?php if (count($verified_patients) > 0): ?>
        <?php foreach ($verified_patients as $patient): ?>
          <article>
            <ul>
              <?php foreach (array_keys($patient) as $detail): ?>
                <?php if (!empty($patient[$detail])): ?>
                  <li><b><?=ucfirst($detail)?></b> <?=': ' . $patient[$detail]?></li>
                <?php endif?>
              <?php endforeach?>
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
              <?php foreach (array_keys($patient) as $detail): ?>
                <?php if (!empty($patient[$detail])): ?>
                  <li><b><?=ucfirst($detail)?></b> <?=': ' . $patient[$detail]?></li>
                <?php endif?>
              <?php endforeach?>
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
