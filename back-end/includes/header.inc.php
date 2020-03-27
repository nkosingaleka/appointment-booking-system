<?php
/**
 * Included section for a consistent header across pages.
 *
 * @category Include
 */
?>

<header>
  <h1><?=$GLOBALS['app']->title?></h1>

  <?php
    // Only show navbar to users that have logged in
    if (isset($_SESSION['user'])) {
      include dirname(__FILE__) . '/nav.inc.php';
    }
  ?>
</header>
