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
   * Creates a new account for the user using their provided account, personal, and next of kin details.
   *
   * @param $data
   * @return void
   */
  static function register($data) {
    // Validate account, personal, and next of kin details
    $valid_account = self::__validateUserDetails($data['email'], $data['password']);
    $valid_patient = self::__validatePatientDetails($data['patient']);
    $valid_nok = self::__validateNextOfKinDetails($data['next_of_kin']);

    if ($valid_account && $valid_patient && $valid_nok) {
      try {
        // Define conditions to be checked in query
        $account_selections = array(
          'email' => array(
            'comparison' => '=',
            'param' => ':email',
            'value' => $data['email'],
          ),
        );

        $patient_selections = array(
          'HC_no' => array(
            'comparison' => '=',
            'param' => ':HC_no',
            'value' => $data['patient']['hc_no'],
            'after' => 'OR',
          ),
          'NHS_no' => array(
            'comparison' => '=',
            'param' => ':NHS_no',
            'value' => $data['patient']['nhs_no'],
          ),
        );

        // Retrieve any record whose email address matches the user's
        $account_result = $GLOBALS['app']->get_db()->selectWhere('account', $account_selections, ['email']);

        // Retrieve any record whose NHS and/or Health and Care number matches the user's
        $patient_result = $GLOBALS['app']->get_db()->selectWhere('patient', $patient_selections, ['NHS_no', 'HC_no']);

        if (isset($account_result['email'])) {
          $GLOBALS['errors'][] = 'Sorry, the email address you entered has already been taken. Please try again.';
        } else if (isset($patient_result['NHS_no']) || isset($patient_result['HC_no'])) {
          $GLOBALS['errors'][] = 'Sorry, the NHS number or Health and Care number you entered has already been taken. Please check your input.';
        } else {
          // Generate a unique ID for the user's account and hash their password
          $user_id = uniqid('', true);
          $new_password = password_hash($data['password'], PASSWORD_DEFAULT);

          $account_data = array(
            'id' => array(
              'param' => ':id',
              'value' => $user_id,
            ),
            'email' => array(
              'param' => ':email',
              'value' => $data['email'],
            ),
            'password' => array(
              'param' => ':password',
              'value' => $new_password,
            ),
          );

          // Generate a unique ID for the next of kin record
          $nok_id = uniqid('', true);

          $nok_data = array(
            'id' => array(
              'param' => ':id',
              'value' => $nok_id,
            ),
          );

          // Set parameters and values for each next of kin detail
          foreach (array_keys($data['next_of_kin']) as $detail) {
            $nok_data[$detail] = array(
              'param' => ":$detail",
              'value' => $data['next_of_kin'][$detail],
            );
          }

          $patient_data = array(
            'id' => array(
              'param' => ':id',
              'value' => $user_id,
            ),
            'next_of_kin' => array(
              'param' => ':next_of_kin',
              'value' => $nok_id,
            ),
          );

          // Set parameters and values for each patient detail
          foreach (array_keys($data['patient']) as $detail) {
            $patient_data[$detail] = array(
              'param' => ":$detail",
              'value' => $data['patient'][$detail],
            );
          }

          // Insert records for the user's account, next of kin, and personal data
          $account_result = $GLOBALS['app']->get_db()->insert('account', $account_data);
          $nok_result = $GLOBALS['app']->get_db()->insert('next_of_kin', $nok_data);
          $patient_result = $GLOBALS['app']->get_db()->insert('patient', $patient_data);

          if ($account_result && $patient_result) {
            // Redirect the user to the home page
            $GLOBALS['app']->redirect_to('index.php');
          } else {
            $GLOBALS['errors'][] = 'An unexpected error has occurred. Please check your input and try again.';
          }
        }
      } catch (PDOException $e) {
        $GLOBALS['errors'][] = $e->getMessage();
      }
    } else {
      $GLOBALS['errors'][] = 'Sorry, your details were in an incorrect format. Please check your input and try again.';
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

  /**
   * Checks whether the user's personal details are in the expected format.
   *
   * @param $details
   * @return boolean
   */
  private static function __validatePatientDetails($details) {
    $excluded = array('house_name', 'house_no', 'mob_no', 'tel_no', 'nhs_no', 'hc_no');

    foreach (array_keys($details) as $detail) {
      if (empty($details[$detail]) && !in_array($detail, $excluded)) {
        $GLOBALS['errors'][] = "Please enter a valid $detail";
        $valid_details[] = true;
      } else {
        $valid_details[] = false;
      }
    }

    if (empty($details['mob_no']) && empty($details['tel_no'])) {
      $GLOBALS['errors'][] = 'Please enter either your mobile number or telephone number, or both.';
      $valid_details[] = false;
    }

    if (empty($details['nhs_no']) && empty($details['hc_no'])) {
      $GLOBALS['errors'][] = 'Please enter either your NHS number or Health and Care number (Northern Ireland only).';
      $valid_details[] = false;
    }

    if (empty($details['house_name']) && empty($details['house_no'])) {
      $GLOBALS['errors'][] = 'Please enter either a house name or house number, or both.';
      $valid_details[] = false;
    }

    if (!in_array(false, $details, true)) {
      return true;
    }

    return false;
  }

  /**
   * Checks whether the user's next of kin details are in the expected format.
   *
   * @param $details
   * @return boolean
   */
  private static function __validateNextOfKinDetails($details) {
    $excluded = array('house_name', 'house_no', 'mob_no', 'tel_no');

    foreach (array_keys($details) as $detail) {
      if (empty($details[$detail]) && !in_array($detail, $excluded)) {
        $GLOBALS['errors'][] = "Please enter a valid $detail";
        $valid_details[] = true;
      } else {
        $valid_details[] = false;
      }
    }

    if (empty($details['mob_no']) && empty($details['tel_no'])) {
      $GLOBALS['errors'][] = 'Please enter either your mobile number or telephone number, or both.';
      $valid_details[] = false;
    }

    if (empty($details['house_name']) && empty($details['house_no'])) {
      $GLOBALS['errors'][] = 'Please enter either a house name or house number, or both.';
      $valid_details[] = false;
    }

    if (!in_array(false, $details, true)) {
      return true;
    }

    return false;
  }
}
