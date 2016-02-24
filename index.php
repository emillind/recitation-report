<!DOCTYPE html>
<html>
<head>
	<title>Recitation Reporter</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<?php include 'header.php'; ?>

	<div class="container">

	<?php

	if ($_GET['loggedin']) {
		echo "logged in";
	} else {
		include 'login.php';
	}

	?>

	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</html>
