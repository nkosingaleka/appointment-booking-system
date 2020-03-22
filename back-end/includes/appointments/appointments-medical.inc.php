<?php

// Retrieve all booked appointments to which the current medical staff member has been assigned
$appointments = BookingManager::getOwnAppointments($_SESSION['user']->id, 'medical');

foreach ($appointments as $appointment) {
  // Find index of current appointment
  $key = array_search($appointment, $appointments);

  // Remove current appointment if it has been cancelled
  if ($appointment['cancelled']) {
    unset($appointments[$key]);
  }
}

?>

<?php include dirname(__FILE__) . '/../error_container.inc.php';?>
<?php include dirname(__FILE__) . '/../success_container.inc.php';?>

<?php if (count($appointments) > 0): ?>
  <table id="appointments-table">
    <thead>
      <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Reason</th>
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
            <?=$appointment['translation']?>
          </td>
          <td>
            <?=ucfirst($appointment['appointment_type'])?>
          </td>
          <td>
            <a class="cancel-btn">Cancel</a>
          </td>
        </tr>
      <?php endforeach?>
    </tbody>
  </table>
<?php else: ?>
  <p>There are no appointments to show.</p>
<?php endif?>
