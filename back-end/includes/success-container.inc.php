<?php if (count($GLOBALS['successes']) > 0): ?>
  <div class="success-message">
    <?php if (count($GLOBALS['successes']) > 1): ?>
      <ul>
        <?php foreach ($GLOBALS['errors'] as $error): ?>
          <li><?=$error?></li>
        <?php endforeach?>
      </ul>
    <?php else: ?>
      <p><?=$GLOBALS['successes'][0]?></p>
    <?php endif ?>
  </div>
<?php endif?>
