<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require dirname(__FILE__) . '/../../vendor/autoload.php';

/**
 * Represents the component for handling user-related actions.
 */
class UserManager {
  /**
   * Retrieves the account details of a given user, referencing their account ID.
   *
   * @param string $userId Account ID of the given user.
   * @return array Collection of account details for the given user.
   */
  public static function getAccount($userId) {
    // Retrieve the type of account the user has
    $user_role = self::getRole($userId);

    // Define parameters based on the user's role
    if ($user_role == PATIENT_ROLE) {
      // Define JOIN tables
      $join_tables = array('patient', 'role');

      // Define JOIN conditions
      $join_conditions = array(
        'account.id = patient.id',
        'account.role_id = role.id',
      );

      // Define columns to select
      $projections = array(
        'date_of_birth',
        "CONCAT(COALESCE(house_no, house_name), ' ', street, ', ', city, ', ', county, ', ', postcode) AS address",
        'tel_no',
        'mob_no',
        'nhs_no',
        'hc_no',
        'contact_by_email',
        'contact_by_text',
      );
    } else {
      // Define JOIN tables
      $join_tables = array('staff', 'role');

      // Define JOIN conditions
      $join_conditions = array(
        'account.id = staff.id',
        'account.role_id = role.id',
      );

      // Define columns to select
      $projections = array(
        'job_title',
      );
    }

    // Define shared columns to select (for any role)
    array_push(
      $projections,
      "CONCAT(title, ' ', forename, ' ', surname) AS full_name",
      'email',
      'sex',
      'role.id AS role',
    );

    // Define conditions to be checked in query
    $selections = array(
      'account.id' => array(
        'comparison' => '=',
        'param' => ':id',
        'value' => $userId,
      ),
    );

    try {
      // Retrieve relevant account details for the given ID
      $account_details = $GLOBALS['app']->getDB()->selectOneJoinWhere('account', $join_tables, $join_conditions, $selections, $projections);

      return $account_details;
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Retrieves the role associated with a given user's account.
   *
   * @param string $userId Account ID of the given user.
   * @return string ID of the role associated with the given user's account.
   */
  public static function getRole($userId) {
    // Define JOIN tables
    $join_tables = array();

    // Define conditions to be checked in query based on the type of user
    $selections = array(
      'account.id' => array(
        'comparison' => '=',
        'param' => ':id',
        'value' => $userId,
      ),
    );

    try {
      // Retrieve the user's role
      $role = $GLOBALS['app']->getDB()->selectOneJoinWhere('account', ['role'], ['account.role_id = role.id'], $selections, ['role.id']);

      return $role['id'];
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Logs the user into their account using their email address and password.
   *
   * @param string $email Email of the user to allow login.
   * @param string $password Password of the user to allow login.
   * @return void
   */
  public static function login($email, $password) {
    // Validate the user's email address and password
    $valid = self::validateUserDetails($email, $password);

    if ($valid) {
      try {
        // Define account conditions to be checked in query
        $account_selections = array(
          'email' => array(
            'comparison' => '=',
            'param' => ':email',
            'value' => $email,
          ),
        );

        // Define account columns to select
        $account_projections = array('id', 'email', 'password', 'role_id', 'verified');

        // Retrieve any record whose email address matches the user's
        $account_result = $GLOBALS['app']->getDB()->selectOneWhere('account', $account_selections, $account_projections);

        if (isset($account_result['email']) && $account_result['email'] === $email) {
          if (password_verify($password, $account_result['password'])) {
            if ($account_result['verified']) {
              // Store details about authenticated and verified users for quick checks
              if ($account_result['role_id'] == PATIENT_ROLE) {
                // Define patient conditions to be checked in query
                $patient_selections = array(
                  'email' => array(
                    'comparison' => '=',
                    'param' => ':email',
                    'value' => $email,
                  ),
                );

                // Define patient columns to select
                $patient_projections = array('mob_no', 'contact_by_email', 'contact_by_text');

                // Retrieve any patient record whose account email address matches the user's
                $patient_result = $GLOBALS['app']->getDB()->selectOneJoinWhere('account', ['patient'], ['account.id = patient.id'], $patient_selections, $patient_projections);

                $_SESSION['user'] = (object) array(
                  'id' => $account_result['id'],
                  'role_id' => $account_result['role_id'],
                  'verified' => $account_result['verified'],
                  'email' => $account_result['email'],
                  'number' => $patient_result['mob_no'],
                  'contact_by_email' => $patient_result['contact_by_email'],
                  'contact_by_text' => $patient_result['contact_by_text'],
                );
              } else {
                $_SESSION['user'] = (object) array(
                  'id' => $account_result['id'],
                  'email' => $account_result['email'],
                  'role_id' => $account_result['role_id'],
                  'verified' => $account_result['verified'],
                );
              }

              // Redirect the user to the home page
              $GLOBALS['app']->redirect('index.php');
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
   * @param array $data Details for account registeration.
   * @return void
   */
  public static function register($data) {
    // Validate account, personal, and next of kin details
    $valid_account = self::validateUserDetails($data['email'], $data['password']);
    $valid_patient = self::validatePatientDetails($data['patient']);
    $valid_nok = self::validateNextOfKinDetails($data['next_of_kin']);

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
        $account_result = $GLOBALS['app']->getDB()->selectOneWhere('account', $account_selections, ['email']);

        // Retrieve any record whose NHS and/or Health and Care number matches the user's
        $patient_result = $GLOBALS['app']->getDB()->selectOneWhere('patient', $patient_selections, ['NHS_no', 'HC_no']);

        if (isset($account_result['email'])) {
          $GLOBALS['errors'][] = 'Sorry, the email address you entered has already been taken. Please try again.';
        } else if (isset($patient_result['NHS_no']) || isset($patient_result['HC_no'])) {
          $GLOBALS['errors'][] = 'Sorry, the NHS number or Health and Care number you entered has already been taken. Please check your input.';
        } else {
          // Generate a unique ID for the user's account and hash their password
          $user_id = uniqid('pa-', true);
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
          $nok_id = uniqid('nk-', true);

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
            'contact_by_email' => array(
              'param' => ':contact_by_email',
              'value' => true,
            ),
            'contact_by_text' => array(
              'param' => ':contact_by_text',
              'value' => true,
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
          $account_result = $GLOBALS['app']->getDB()->insert('account', $account_data);
          $nok_result = $GLOBALS['app']->getDB()->insert('next_of_kin', $nok_data);
          $patient_result = $GLOBALS['app']->getDB()->insert('patient', $patient_data);

          if ($account_result && $patient_result) {
            // Redirect the user to the home page
            $GLOBALS['app']->redirect('index.php');
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
   * @param string $email Email of the user to allow login.
   * @param string $password Password of the user to allow login.
   * @return boolean Whether the registering patients email address and password pass (true) or fail (false) validation.
   */
  private static function validateUserDetails($email, $password) {
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
   * @param array $details Details about the registeration patients.
   * @return boolean Whether the registering patients details pass (true) or fail (false) validation.
   */
  private static function validatePatientDetails($details) {
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
   * @param array $details Details about the user's next of kin.
   * @return boolean Whether the registering patients next of kin details pass (true) or fail (false) validation.
   */
  private static function validateNextOfKinDetails($details) {
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

  /**
   * Retrieves patient details from the database.
   *
   * @return array Collection of patients details.
   */
  public static function getPatients() {
    $columns = array(
      'account.id',
      'email',
      'verified',
      'title',
      'forename',
      'surname',
      'sex',
      'date_of_birth',
      'house_name',
      'house_no',
      'street',
      'city',
      'county',
      'postcode',
      'tel_no',
      'mob_no',
      'next_of_kin',
      'NHS_no',
      'HC_no',
    );

    return $GLOBALS['app']->getDB()->selectJoin('account', ['patient'], ['account.id = patient.id'], $columns);
  }

  /**
   * Verifies the patient using the given account id.
   *
   * @param string $id ID of the patients account.
   * @return void
   */
  public static function verifyPatient($id) {
    $selections = array(
      'id' => array(
        'comparison' => '=',
        'param' => ':id',
        'value' => $id,
      ),
    );

    $update_columns = array(
      'verified' => array(
        'param' => ':verified',
        'value' => true,
      ),
    );

    $verify_result = $GLOBALS['app']->getDB()->updateWhere('account', $selections, $update_columns);

    if ($verify_result) {
      // Redirect the user to the patient accounts page
      $GLOBALS['app']->redirect('patient-accounts.php');
    } else {
      $GLOBALS['errors'][] = 'An unexpected error has occurred. Please check the patient you selected and try again.';
    }
  }

  /**
   * Receives an email message sent from the application to inform users of updates. Note: to work with Google Mail, the 'Less secure app access' option must be enabled.
   *
   * @param string $userid The ID of the user's account.
   * @param string $message Message to inform users of updates.
   * @return void
   */
  public static function receiveEmail($userId, $message) {
    $mail = new PHPMailer;

    // Enable verbose error outputs
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;

    $mail->IsSMTP();
    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,
      ),
    );
    $mail->Host = 'smtp.gmail.com';
    // $mail->Host = gethostbyname('smtp.gmail.com'); // if server doesnt allow ipv6
    $mail->SMTPAuth = true;
    $mail->Username = 'team9c.abs@gmail.com';
    $mail->Password = '39ThiS4is23A8SeCuRE215PassWoRd234';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 587; // 465 or 587
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->IsHTML(true);

    // Add sender
    $mail->SetFrom('team9c.abs@gmail.com', 'Appointment Booking System');

    // Add recipient
    $mail->AddAddress($_SESSION['user']->email, $_SESSION['user']->id);

    $mail->Subject = 'Appointment Booking System Update';
    $mail->Body = $message;
    $mail->AltBody = $message;

    if (!$mail->Send()) {
      $GLOBALS['errors'][] = 'Mailer Error: ' . $mail->ErrorInfo;
    }
  }

  /**
   * Retrieves the details of the user's facility.
   *
   * @param string $userId The ID of the user's account.
   * @return string The details of the user's facility.
   */
  public static function getUserFacility($userId) {
    // Define conditions to be checked in query
    $selections = array(
      'id' => array(
        'comparison' => '=',
        'param' => ':id',
        'value' => $userId,
      ),
    );

    // Retrieve the record containing the facility ID whose account ID matches the user's ID
    $result = $GLOBALS['app']->getDB()->selectOneWhere('account', $selections, ['facility_id']);

    if ($result) {
      // Retrieve contact details for the patient's facility
      return FacilityManager::getContactDetails($result['facility_id']);
    } else {
      $GLOBALS['errors'][] = 'An unexpected error has occurred. Please check your input and try again.';
    }
  }

  /**
   * Receives an sms message sent from the application to inform users of updates.
   *
   * @param string $userId The ID of the user's account.
   * @param string $message Message to inform users of updates.
   * @return void
   */
  public static function receiveSms($userId, $message) {
    // Account details
    $apiKey = urlencode('8YH9denGK10-rBz9vXQyecv3VwXGKkTHZidAnberwL');

    // Message details
    $numbers = array($_SESSION['user']->number);
    $message = rawurlencode($message);
    $facility = urlencode('Appointment Booking System');

    $numbers = implode(',', $numbers);

    // Prepare data for POST request
    $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $facility, "message" => $message);

    // Send the POST request with cURL
    $ch = curl_init('https://api.txtlocal.com/send/');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
  }

  /**
   * Sets the given user's contact preferences to allow or disallow email messages.
   *
   * @param string $userId Account ID of the given user.
   * @param boolean $choice Whether the user wants to allow (true) or disallow (false) email messages.
   * @return void
   */
  public static function updateContactByEmail($userId, $choice) {
    try {
      // Define conditions to be checked in query
      $selections = array(
        'id' => array(
          'comparison' => '=',
          'param' => ':id',
          'value' => $userId,
        ),
      );

      // Define columns to be updated
      $update_columns = array(
        'contact_by_email' => array(
          'param' => ':contact_by_email',
          'value' => $choice,
        ),
      );

      // Set email messaging preferences for the given user
      $contact_result = $GLOBALS['app']->getDB()->updateWhere('patient', $selections, $update_columns);

      if ($contact_result) {
        $success_msg = 'Your contact preferences have been updated successfully.';

        if (!in_array($success_msg, $GLOBALS['successes'])) {
          $GLOBALS['successes'][] = $success_msg;
        }
      } else {
        $GLOBALS['errors'][] = 'Sorry, an unexpected error has occurred while updating your contact preferences. Please try again.';
      }
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Sets the given user's contact preferences to allow or disallow text (SMS) messages.
   *
   * @param string $userId Account ID of the given user.
   * @param boolean $choice Whether the user wants to allow (true) or disallow (false) text (SMS) messages.
   * @return void
   */
  public static function updateContactByText($userId, $choice) {
    try {
      // Define conditions to be checked in query
      $selections = array(
        'id' => array(
          'comparison' => '=',
          'param' => ':id',
          'value' => $userId,
        ),
      );

      // Define columns to be updated
      $update_columns = array(
        'contact_by_text' => array(
          'param' => ':contact_by_text',
          'value' => $choice,
        ),
      );

      // Set text messaging preferences for the given user
      $contact_result = $GLOBALS['app']->getDB()->updateWhere('patient', $selections, $update_columns);

      if ($contact_result) {
        $success_msg = 'Your contact preferences have been updated successfully.';

        if (!in_array($success_msg, $GLOBALS['successes'])) {
          $GLOBALS['successes'][] = $success_msg;
        }
      } else {
        $GLOBALS['errors'][] = 'Sorry, an unexpected error has occurred while updating your contact preferences. Please try again.';
      }
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }
}
