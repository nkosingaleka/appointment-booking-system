<?php
// Retrieve the patient's own requests
$requests = RequestManager::getOwnRequests($_SESSION['user']->id);

?>

<?php if (count($requests) > 0): ?>
  <?php foreach ($requests as $request): ?>
    <article>
      <h3>Appointment #<?=array_search($request, $requests) + 1 ?></h3>

      <span>
        <strong>Reason:</strong>
        <?=$request['reason'] ?>
      </span>

      <span>
        <strong>Translation Required:</strong>
        <?=$request['translation'] ?>
      </span>

      <span>
        <strong>Preferred Staff Member:</strong>
        <?=$request['staff'] ?>
      </span>

      <h4>Preferred Slots</h4>

      <?php foreach ($request['slots'] as $slot): ?>
        <ul>
          <li>
            <span>
              <strong>Slot #<?=array_search($slot, $request['slots']) + 1 ?>:</strong>
              <?=date('d/m/Y H:i:s', strtotime($slot['start_time'])) ?> &ndash; <?=explode(' ', $slot['end_time'])[1] ?>
            </span>
          </li>
        </ul>
      <?php endforeach ?>
    </article>
  <?php endforeach ?>
<?php endif ?>
