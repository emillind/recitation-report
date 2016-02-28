<?php
session_start();
include_once 'header.php';
?>

<div class="alert alert-success" role="alert"><?php echo "Successfully logged in  <strong>".$_SESSION['username']."</strong>!"; ?></div>

<div class="page-header">
  <h1>Recitations</h1>

  <div class="btn-group">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Select course <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <li><a>DD1368 - Databasteknik för D</a></li>
    </ul>
  </div>
  <div class="btn-group">
    <button class="btn btn-default dropdown-toggle disabled" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      # <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <li><a>1</a></li>
      <li><a>2</a></li>
      <li><a>3</a></li>
      <li><a>4</a></li>
    </ul>
  </div>
  <div class="btn-group">
    <button class="btn btn-default dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Group <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <li><a>A (12 spots left)</a></li>
      <li><a>B (9 spots left)</a></li>
      <li><a>C (19 spots left)</a></li>
      <li class="disabled"><a>D (All spots taken)</a></li>
    </ul>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Recitation 2 (2016-01-12)<span class="pull-right">Group A</span></h3>
  </div>
  <div class="panel-body">
    <button class="btn btn-success">Lock in claims</button>
  </div>
</div>

<?php
include_once 'footer.php';
?>
