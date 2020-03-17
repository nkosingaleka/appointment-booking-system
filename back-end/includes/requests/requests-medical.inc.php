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
  <?php foreach ($requests as $request): ?>
    <article id="<?=$request['id']?>">
      <h3>Appointment #<?=array_search($request, $requests) + 1?></h3>

      <span>
        <strong>Reason:</strong>
        <?=$request['reason']?>
      </span>

      <span>
        <strong>Translation Required:</strong>
        <?=$request['translation']?>
      </span>

      <span>
        <strong>Preferred Staff Member:</strong>
        <?=$request['staff']?>
      </span>

      <h4>Preferred Slots</h4>

      <ol>
        <?php foreach ($request['slots'] as $slot): ?>
          <li>
            <?=date('d/m/Y H:i:s', strtotime($slot['start_time']))?> &ndash; <?=explode(' ', $slot['end_time'])[1]?>
          </li>
        <?php endforeach?>
      </ol>

      <a class="cancel-btn">Cancel</a>
    </article>
  <?php endforeach?>
<?php else: ?>
  <p>There are no appointment booking requests to show.</p>
<?php endif?>
