<?php
session_start();
include_once 'header.php';
include_once 'submitclaim.php';

//Connect to db
$dbconn = pg_connect('dbname=recitationreport');
if (!$dbconn) {
  echo "Error: Could not connect to database. \n";
  exit;
}

//If available courses hasn't been set, query db and set it.
if (!isset($_SESSION['courses'])) {
  $query = "SELECT DISTINCT(c.cID), c.name FROM Course c, Recitation r, Takes t WHERE t.cID = c.cID AND t.studentID = '".$_SESSION['username']."'";
  $result = pg_fetch_all(pg_query($dbconn, $query));
  if (!$result) {
    echo "An error occurred. \n";
    exit;
  } else {
    $_SESSION['courses'] = $result;
  }
}

//If a course has been selected, fetch available recitations for the course.
if (isset($_GET['course'])) {
  $query = "SELECT num FROM Recitation WHERE cid = '".$_GET['course']."'";
  $result = pg_fetch_all(pg_query($dbconn, $query));
  if (!$result) {
    echo "An error occurred. No recitations for selected course was found.\n";
    exit;
  } else {
    $_SESSION['recitations'] = $result;
  }

  //If a course and a recitation has been selected, fetch available groups for the recitation.
  if (isset($_GET['recitation'])) {
    $query = "SELECT name, maxlimit FROM RecitationGroup WHERE num = ".$_GET['recitation']." AND cid = '".$_GET['course']."'";
    $result = pg_fetch_all(pg_query($dbconn, $query));
    if (!$result) {
      echo "An error occurred. No groups for selected course+recitation was found.\n";
      exit;
    } else {
      $_SESSION['groups'] = $result;
    }

    //If a course, a recitation and a group has been selected, fetch the problems.
    if (isset($_GET['group'])) {
      $query = "SELECT h.recnum, h.problemset, h.condition, rg.dategiven, rg.name, h.cid FROM hasproblems h, recitationgroup rg WHERE h.cid = rg.cid AND h.recnum = rg.num AND h.cid = '". $_GET['course'] ."' AND h.recnum = ". $_GET['recitation'] ." AND rg.name = '". $_GET['group'] ."'";
      $result = pg_fetch_array(pg_query($dbconn, $query));
      if (!$result) {
        echo "An error occurred. No problems for selected course+recitation+group was found.\n";
        exit;
      } else {
        $_SESSION['problems'] = $result;
      }

    } else {
      unset($_SESSION['problems']); //For hiding recitation data.
    }
  } else {
    unset($_SESSION['problems']); //For hiding recitation data.
  }
} else {
  unset($_SESSION['problems']); //For hiding recitation data.
}

pg_close($dbconn);
?>
<?php if (!isset($_SESSION['loginbanner'])) { ?>
<div class="alert alert-info" role="alert"><?php echo "Successfully logged in  <strong>".$_SESSION['name']."</strong>!"; ?></div>
<?php $_SESSION['loginbanner'] = false; } ?>
<div class=""><h1>Welcome <?php echo $_SESSION['name'] ?>!</h1><p>
  Use the buttons below to select a recitation to submit claims to.
</p></div>
<div class="page-header">
  <h2>Recitations</h2>

  <!-- Course select -->
  <div class="btn-group">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php
      if (isset($_GET['course'])) {
        echo $_GET['course']."";
      } else {
        echo "Select course";
      }
      ?>
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <?php
      //Print out all courses available as a list.
      foreach ($_SESSION['courses'] as $course) {
          echo "<li><a href='?course=" . $course['cid'] . "'>";
          echo $course['cid'] . " - " . $course['name'];
          echo "</a></li>";
      }
      ?>
    </ul>
  </div>

  <!-- Recitation select -->
  <div class="btn-group">
    <button class="btn btn-default dropdown-toggle <?php if(!isset($_GET['course'])){ echo "disabled"; }?>" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php
      if (isset($_GET['recitation'])) {
        echo "Recitation ".$_GET['recitation'];
      } else {
        echo "Select recitation";
      }
      ?>
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <?php
      //Print out all recitations available for a course as a list.
      foreach ($_SESSION['recitations'] as $recitation) {
          echo "<li><a href='?course=" . $_GET['course'] . "&recitation=" . $recitation['num'] . "'>";
          echo "Recitation " . $recitation['num'];
          echo "</a></li>";
      }
      ?>
    </ul>
  </div>

  <!-- Group select -->
  <div class="btn-group">
    <button class="btn btn-default dropdown-toggle <?php if(!(isset($_GET['course']) && isset($_GET['recitation']))){ echo "disabled"; }?>" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php
      if (isset($_GET['group'])) {
        echo "Group ".$_GET['group'];
      } else {
        echo "Select group";
      }
      ?>
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <?php
      //Print out all groups available for a course+recitation as a list.
      foreach ($_SESSION['groups'] as $group) {
          echo "<li><a href='?course=" . $_GET['course'] . "&recitation=" . $_GET['recitation'] . "&group=" . $group['name'] . "'>";
          echo "Group " . $group['name'];
          echo "</a></li>";
      }
      ?>
    </ul>
  </div>
</div>

<?php if (isset($_SESSION['problems']) && $_SESSION['problems'] != null) { ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Recitation <?php echo $_SESSION['problems']['recnum'] ?> <span class="pull-right">Group <?php echo $_SESSION['problems']['name']; ?></span></h3>
  </div>
  <div class="panel-body">
    <form class="" action="welcome.php" method="post">
      <div class="row">
        <?php
        $problems = preg_split("/[\d]/", $_SESSION['problems']['problemset']);
        for ($i=1; $i < count($problems); $i++) {
          echo "<div class='col-md-2'><div class='panel panel-default'><div class='panel-body'><strong>Problem ".($i)."</strong><br/>";
          $probs = str_split($problems[$i]);
          foreach ($probs as $val) {
            if ($val != "") {
              echo strtoupper($val)." <input type='checkbox' name='$i$val'/><br/>";
            }
          }
          echo "</div></div></div>";
        }
        ?>
      </div>
      <input type=submit value="Lock in claims" name="submitclaims" class="btn btn-danger"/>
    </form>
  </div>
</div>
<?php } ?>
<?php
include_once 'footer.php';
?>
