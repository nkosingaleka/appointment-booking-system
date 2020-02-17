<?php

class UserManager {
  /**
   * Logs the user into their account using their email address and password.
   *
   * @param $email
   * @param $password
   * @return void
   */
  static function login($email, $password) {
    // Validate the user's email address and password
    $valid = self::__validateUserDetails($email, $password);

    if ($valid) {
      try {
        // Define conditions to be checked in query
        $selections = array(
          'email' => array(
            'comparison' => '=',
            'param' => ':email',
            'value' => $email,
          ),
        );

        // Define columns to select
        $projections = array('id', 'email', 'password', 'role_id', 'verified');

        // Retrieve any record whose email address matches the user's
        $result = $GLOBALS['app']->get_db()->selectWhere('account', $selections, $projections);

        if (isset($result['email']) && $result['email'] === $email) {
          if (password_verify($password, $result['password'])) {
            if ($result['verified']) {
              // Store details about authenticated and verified users for quick checks
              $_SESSION['user'] = (object) array(
                'id' => $result['id'],
                'role_id' => $result['role_id'],
                'verified' => $result['verified'],
              );

              // Redirect the user to the home page
              $GLOBALS['app']->redirect_to('index.php');
            } else {
              $GLOBALS['errors'][] = 'Sorry, your account is not yet verified. If you have any queries, please contact your medical facility.';
            }
          } else {
            $GLOBALS['errors'][] = 'Sorry, your email address and password combination was incorrect. Please check your input and try again.';
          }
        } else {
          $GLOBALS['errors'][] = 'Sorry, your email address was not found. Please check your input and try again.';
        }
      } catch (PDOException $e) {
        $GLOBALS['errors'][] = $e->getMessage();
      }
    } else {
      $GLOBALS['errors'][] = 'Sorry, your email or password was in an incorrect format. Please check your input and try again.';
    }
  }

  /**
   * Checks whether the user's email address and password are in the expected format.
   *
   * @param $email
   * @param $password
   * @return boolean
   */
  private static function __validateUserDetails($email, $password) {
    if (empty($email) || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
      $GLOBALS['errors'][] = 'Please enter a valid email address.';
    } else if (empty($password)) {
      $GLOBALS['errors'][] = 'Please enter a valid password.';
    } else {
      return true;
    }

    return false;
  }
