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
    <?php include dirname(__FILE__) . '/../back-end/includes/error_container.inc.php';?>
  </main>
</body>

</html>
