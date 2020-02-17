<?php if (count($GLOBALS['errors']) > 0): ?>
  <div class="error-message">
    <ul>
      <?php foreach ($GLOBALS['errors'] as $error): ?>
        <li><?=$error?></li>
      <?php endforeach?>
    </ul>
  </div>
<?php endif?>
