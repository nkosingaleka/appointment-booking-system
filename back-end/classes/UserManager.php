<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require dirname(__FILE__) . '/../../vendor/autoload.php';

/**
 * Represents the component for handling user-related actions.
 */
class UserManager {
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
        $result = $GLOBALS['app']->getDB()->selectOneWhere('account', $selections, $projections);

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

    return $GLOBALS['app']->getDB()->selectJoin('account', 'patient', 'account.id = patient.id', $columns);
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
   * @return void
   */
  public static function receiveEmail() {
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
    $mail->SetFrom('team9c.abs@gmail.com', 'MEDICAL_FACILITY');

    // Add recipient
    $mail->AddAddress('up734426@myport.ac.uk', 'PATIENT_NAME');

    $mail->Subject = 'This is a test email';
    $mail->Body = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$mail->Send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      echo 'Message has been sent';
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

  public static function receiveSMS(){

    // Account details
	$apiKey = urlencode('8YH9denGK10-rBz9vXQyecv3VwXGKkTHZidAnberwL');
	
	// Message details
	$numbers = array(447519321905);
	$sender = urlencode('Team9c');
	$message = rawurlencode('This is a test');
 
	$numbers = implode(',', $numbers);
 
	// Prepare data for POST request
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
	// Send the POST request with cURL
	$ch = curl_init('https://api.txtlocal.com/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	
	// Process your response here
	echo $response;


  }
}
