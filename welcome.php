<?php
session_start();
include_once 'header.php';
?>

<div class="alert alert-success" role="alert"><?php echo "Successfully logged in  <strong>".$_SESSION['username']."</strong>!"; ?></div>

<?php
include_once 'footer.php';
?>
