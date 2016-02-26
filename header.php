<!DOCTYPE html>
<html>
<head>
	<title>Recitation Reporter</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="/">Recitation Reporter</a>
      </div>
			<!-- If user is logged in we show a log out button -->
			<?php if(isset($_SESSION['username'])){ ?>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="logout.php">Log out</a></li>
				</ul>
			<?php } ?>
    </div>
  </nav>
  <div class="container">
