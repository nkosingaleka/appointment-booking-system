<?php
require_once dirname(__FILE__) . '/../../back-end/init.php';

session_start();

// Delete session data
session_destroy();
unset($_SESSION['user']);

// Redirect to login page
$GLOBALS['app']->redirect('../login.php');
