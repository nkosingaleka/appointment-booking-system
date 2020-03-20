<?php
require_once dirname(__FILE__) . '/../back-end/init.php';

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    UserManager::verifyPatient($id);

    // Redirect to patient accounts page
    $GLOBALS['app']->redirect('patient-accounts.php');

} else {
    echo 'Patient ID not given';
}
