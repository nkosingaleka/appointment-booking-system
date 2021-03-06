<?php

/**
 * Included section for administrative staff to perform request-related operations.
 *
 * @category Include
 */

// Retrieve the available appointment types to assign to requests
$appointment_types = RequestManager::getAppointmentTypes();

// Retrieve all reviewed requests
$requests = RequestManager::getApprovedRequests();

foreach ($requests as $request) {
  // Find index of current request
  $key = array_search($request, $requests);

  // Remove current request if it has been cancelled
  if ($request['cancelled']) {
    unset($requests[$key]);
  }
}

// Check if request has been cancelled
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($requests as $request) {
    // Extract ID for use in comparison with form input fields
    $id = str_replace('.', '_', $request['id']);

    if (isset($_POST["$id-id"])) {
      $data = array(
        'to_cancel' => $_POST["$id-id"],
        'cancellation_reason' => isset($_POST["$id-reason"]) ? $_POST["$id-reason"] : null,
        'requests' => $requests,
        'patient_id' => $request['patient_id'],
        'patient_contact_by_email' => $request['contact_by_email'],
        'patient_contact_by_text' => $request['contact_by_text'],
      );
    }
  }

  // Cancel the selected request
  RequestManager::cancelRequest($data);

  // Refresh the page
  header("Refresh:" . REFRESH_PERIOD);
}

?>

<?php include dirname(__FILE__) . '/../error-container.inc.php';?>
<?php include dirname(__FILE__) . '/../success-container.inc.php';?>

<?php if (count($requests) > 0): ?>
  <table id="requests-table">
    <thead>
      <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Staff Member</th>
        <th>Reason</th>
        <th>Translation Required</th>
        <th>Appointment Type</th>
        <th>Book</th>
        <th>Cancel</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($requests as $request): ?>
        <tr id="<?=$request['id']?>">
          <td>
            <ul>
              <?php foreach ($request['slots'] as $slot): ?>
                  <li>
                    <?=date('d/m/Y', strtotime($slot['start_time']))?>
                  </li>
                <?php endforeach?>
            </ul>
          </td>
          <td>
            <ul>
              <?php foreach ($request['slots'] as $slot): ?>
                  <li>
                    <?=date('H:i', strtotime($slot['start_time']))?>
                  </li>
                <?php endforeach?>
            </ul>
          </td>
          <td>
            <?=$request['staff']?>
          </td>
          <td>
            <?=$request['reason']?>
          </td>
          <td>
            <?=$request['translation']?>
          </td>
          <td>
            <?php foreach ($appointment_types as $type): ?>
              <?php if ($request['appointment_type'] === $type['id']): ?>
                <?=ucfirst($type['title'])?>
              <?php endif?>
            <?php endforeach?>
          </td>
          <td>
            <a class="btn" href="book-appointment.php?request_id=<?=$request['id']?>">Book</a>
          </td>
          <td>
            <a class="btn danger-btn">Cancel</a>
          </td>
        </tr>
      <?php endforeach?>
    </tbody>
  </table>
<?php else: ?>
  <p>There are no appointment booking requests to show.</p>
<?php endif?>
