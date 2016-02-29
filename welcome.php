<?php
session_start();
include_once 'header.php';

$dbconn = pg_connect('dbname=recitationreport');

$courses = null;

$username = $_SESSION['username'];
$query = "SELECT DISTINCT(c.cID), c.name FROM Course c, Recitation r, Takes t WHERE t.cID = c.cID AND t.studentID = '$username'";
$courses = pg_query($dbconn, $query);

if (isset($_GET['course'])) {
  $_SESSION['course'] = $_GET['course'];
  $query2 = "SELECT num FROM Recitation WHERE cid = '".$_SESSION['course']."'";
  $recitations = pg_query($dbconn, $query2);
  if (isset($_GET['recitation'])) {
    $_SESSION['recitation'] = $_GET['recitation'];
    $query3 = "SELECT name, maxlimit FROM RecitationGroup WHERE num = ".$_SESSION['recitation']." AND cid = '".$_SESSION['course']."'";
    $groups = pg_query($dbconn, $query3);
    if (isset($_GET['group'])) {
      $_SESSION['group'] = $_GET['group'];
      $query4 = "SELECT problemset, condition FROM hasproblems WHERE cid = '".$_SESSION['course']."' AND recnum = ".$_SESSION['recitation']."";
      $result = pg_fetch_row(pg_query($dbconn, $query4));
      $_SESSION['problems'] = $result[0];
      $_SESSION['condition'] = $result[1];
    }

  }

}
include_once 'submitclaim.php';

?>

<div class="alert alert-success" role="alert"><?php echo "Successfully logged in  <strong>".$_SESSION['name']."</strong>!"; ?></div>

<div class="page-header">
  <h1>Recitations</h1>

  <div class="btn-group">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php if (isset($_GET['course'])) {
        echo $_GET['course']."";
      } else {
        echo "Select course";
      } ?> <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <?php
          while ($row = pg_fetch_row($courses)) {
            echo "<li><a href='?course=$row[0]'>$row[0] - $row[1]</a></li>";
          }
      ?>
    </ul>
  </div>
  <div class="btn-group">
    <button class="btn btn-default dropdown-toggle <?php if(!isset($_GET['course'])){ echo "disabled"; }?>" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php if (isset($_GET['recitation'])) {
        echo "Recitation ".$_GET['recitation'];
      } else {
        echo "Select recitation";
      } ?> <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <?php
          while ($row2 = pg_fetch_row($recitations)) {
            echo "<li><a href='?course=".$_SESSION['course']."&recitation=$row2[0]'>Recitation $row2[0]</a></li>";
          }
      ?>
    </ul>
  </div>
  <div class="btn-group">
    <button class="btn btn-default dropdown-toggle <?php if(!(isset($_GET['course']) && isset($_GET['recitation']))){ echo "disabled"; }?>" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php if (isset($_GET['group'])) {
        echo "Group ".$_GET['group'];
      } else {
        echo "Select group";
      } ?> <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <?php
          while ($row3 = pg_fetch_row($groups)) {
            echo "<li><a href='?course=".$_SESSION['course']."&recitation=".$_SESSION['recitation']."&group=$row3[0]'>Group $row3[0] ($row3[1] spots left)</a></li>";
          }
      ?>
    </ul>
  </div>
</div>

<?php if (isset($_SESSION['problems']) && $_SESSION['problems'] != null) { ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Recitation <?php echo $_SESSION['recitation'] ?> <span class="pull-right">Group <?php echo $_SESSION['group']; ?></span></h3>
  </div>
  <div class="panel-body">
    <form class="" action="welcome.php" method="post">
    <div class="row">
    <?php
      $problems = preg_split("/[\d]/", $_SESSION['problems']);
      for ($i=1; $i < count($problems); $i++) {
        echo "<div class='col-md-2'><div class='panel panel-default'><div class='panel-body'><strong>Problem ".($i)."</strong><br/>";
        $probs = str_split($problems[$i]);
        foreach ($probs as $val) {
          echo strtoupper($val)." <input type='checkbox' name='$i$val'/><br/>";
        }
        echo "</div></div></div>";
      }
     ?>
   </div>
    <input type=submit value="Lock in claims" name="submit2" class="btn btn-danger"/>
    </form>
  </div>
</div>
<?php } ?>
<?php
include_once 'footer.php';
?>
