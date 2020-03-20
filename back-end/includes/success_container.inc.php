<?php if (count($GLOBALS['successes']) > 0): ?>
  <div class="success-message">
    <ul>
      <?php foreach ($GLOBALS['successes'] as $success): ?>
        <li><?=$success?></li>
      <?php endforeach?>
    </ul>
  </div>
<?php endif?>
