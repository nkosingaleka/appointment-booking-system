<?php

// Retrieve all requests for which the current medical staff member is preferred
$requests = RequestManager::getOwnRequests($_SESSION['user']->id, 'medical');

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
  header("Refresh:0");
}

?>

<?php include dirname(__FILE__) . '/../error_container.inc.php';?>

<?php if (count($requests) > 0): ?>
  <table>
    <thead>
      <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Staff Member</th>
        <th>Reason</th>
        <th>Translation Required</th>
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
                    <?=date('d/m/Y', strtotime($slot['start_time']))?> &ndash; <?=explode(' ', $slot['end_time'])[1]?>
                  </li>
                <?php endforeach?>
            </ul>
          </td>
          <td>
            <ul>
              <?php foreach ($request['slots'] as $slot): ?>
                  <li>
                    <?=date('H:i:s', strtotime($slot['start_time']))?> &ndash; <?=explode(' ', $slot['end_time'])[1]?>
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
            <a class="cancel-btn">Cancel</a>
          </td>
        </tr>
      <?php endforeach?>
    </tbody>
  </table>
<?php else: ?>
  <p>There are no appointment booking requests to show.</p>
<?php endif?>
