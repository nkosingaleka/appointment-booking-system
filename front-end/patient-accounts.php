<?php

require_once '../back-end/init.php';

session_start();

// Checks for if the user is logged in and if necessary to redirect them to the login page
if (!isset($_SESSION['user'])) {
    $GLOBALS['app']->redirect('login.php');
} else {
    // Redirect people who are not admin staff
    if ($_SESSION['user']->role_id != 1) {
        $GLOBALS['app']->redirect('index.php');
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

    <button>Verified</button>
    <button>Unverified</button>

    <?php if (count($patients) > 0): ?>
    <?php endif?>
  </main>
</body>
</html>
