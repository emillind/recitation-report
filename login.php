<?php
session_start();
$error = "";
//If submit button from login form is pressed...
if (isset($_POST['submit'])) {

  //Check that both username and password is filled in
  if (empty($_POST['username']) || empty($_POST['password'])) {
    $error = "Please input both username and password!";
  } else {
    $username=$_POST['username'];
    $password=$_POST['password'];

    //Check username matches password here
    if (true) {
      $_SESSION['username'] = $username;
    } else {
      $error = "Username or Password is invalid";
    }
  }
}
?>
