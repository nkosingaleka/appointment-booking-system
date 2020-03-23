<?php
require_once '../back-end/init.php';

session_start();

// Redirect users who have already logged in to the home page
if (isset($_SESSION['user'])) {
  $GLOBALS['app']->redirect('index.php');
}

// Check if the login form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['email'], $_POST['password'])) {
    // Sanitise the user's inputs
    $email = trim(htmlspecialchars($_POST['email']));
    $password = htmlspecialchars($_POST['password']);

    // Log the user in
    UserManager::login($email, $password);
  } else {
    $GLOBALS['errors'][] = 'Please enter a valid email address and password.';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include dirname(__FILE__) . '/../back-end/includes/head-elements.inc.php';?>
  <title><?=$GLOBALS['app']->title?> &mdash; Login</title>
</head>

<body>
  <?php include dirname(__FILE__) . '/../back-end/includes/header.inc.php';?>

  <main>
    <?php include dirname(__FILE__) . '/../back-end/includes/error_container.inc.php';?>

    <form method="post" id="login-form">
      <h2>Login</h2>

      <p>Please log in with your email address and password.</p>

      <label for="email">
        Email Address
        <input type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" required>
      </label>
      <label for="password">
        Password
        <input type="password" name="password" id="password" required>
      </label>

      <a href="register.php" id="register">Register</a>
      <input type="submit" value="Log in" id="login">
    </form>
  </main>

  <script src="js/login.js"></script>
</body>

</html>
