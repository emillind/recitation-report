<?php
$claimedSet = "";
if (isset($_POST['submit2'])) {
foreach ($_POST as $key => $value) {
  if ($value == 'on') {
    $claimedSet = $claimedSet.$key;
  }
}

$claimQuery = "INSERT INTO Claims VALUES ('$username', '".$_SESSION['problems']."', '".$_SESSION['condition']."', '".$_SESSION['course']."', '".$_SESSION['recitation']."', '".$_SESSION['group']."', '$claimedSet')";
$result = pg_query($dbconn, $claimQuery);
unset($_SESSION['problems']);
header('Location: welcome.php');
}
?>
