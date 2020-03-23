<?php

// Retrieve all booked appointments to which the current medical staff member has been assigned
$appointments = BookingManager::getOwnAppointments($_SESSION['user']->id, 'patient');

foreach ($appointments as $appointment) {
  // Find index of current appointment
  $key = array_search($appointment, $appointments);

  // Remove current appointment if it has been cancelled
  if ($appointment['cancelled']) {
    unset($appointments[$key]);
  }
}

// Check if appointment has been cancelled
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($appointments as $appointment) {
    // Extract ID for use in comparison with form input fields
    $id = str_replace('.', '_', $appointment['id']);

    if (isset($_POST["$id-id"])) {
      $data = array(
        'to_cancel' => $_POST["$id-id"],
        'cancellation_reason' => isset($_POST["$id-reason"]) ? $_POST["$id-reason"] : null,
        'appointments' => $appointments,
      );
    }
  }

  // Cancel the selected appointment
  BookingManager::cancelAppointment($data);

  // Refresh the page
  header("Refresh:" . REFRESH_PERIOD);
}

?>

<?php include dirname(__FILE__) . '/../error-container.inc.php';?>
<?php include dirname(__FILE__) . '/../success-container.inc.php';?>

<?php if (count($appointments) > 0): ?>
  <table id="appointments-table">
    <thead>
      <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Reason</th>
        <th>Staff Member</th>
        <th>Translation Required</th>
        <th>Appointment Type</th>
        <th>Cancel</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($appointments as $appointment): ?>
        <tr id="<?=$appointment['id']?>">
          <td>
            <?=date('d/m/Y', strtotime($appointment['start_time']))?>
          </td>
          <td>
            <?=date('H:i', strtotime($appointment['start_time']))?>
          </td>
          <td>
            <?=$appointment['reason']?>
          </td>
          <td>
            <?=$appointment['staff']?>
          </td>
          <td>
            <?=$appointment['translation']?>
          </td>
          <td>
            <?=ucfirst($appointment['appointment_type'])?>
          </td>
          <td>
            <a class="btn danger-btn">Cancel</a>
          </td>
        </tr>
      <?php endforeach?>
    </tbody>
  </table>
<?php else: ?>
  <p>There are no appointments to show.</p>
<?php endif?>
