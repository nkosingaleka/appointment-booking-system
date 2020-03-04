<?php

require_once '../back-end/init.php';

session_start();

// Retrieve slots from the database
$slots = AvailabilityManager::getSlots();

// Return slots in JSON format
echo json_encode($slots);
