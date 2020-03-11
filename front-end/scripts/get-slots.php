<?php

require_once dirname(__FILE__) . '/../../back-end/init.php';

session_start();

// Retrieve slots from the database
$slots = AvailabilityManager::getSlots();

// Return slots in JSON format
echo json_encode($slots);
