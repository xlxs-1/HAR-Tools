<?php
session_start();
include (__DIR__.'/../utils.php');
$database=new database();

if (!isset($_POST["email"])||!isset($_POST["password"])||!isset($_POST["button"])) {
  // code...
}elseif ($_POST["button"]==="Login") {
  $_SESSION=[];
  $account=$database->getAccount($_POST["email"],$_POST["password"]);
  if ($account) {
    $_SESSION["email"]=$account["email"];
    $_SESSION["password"]=$account["password"];
    $_SESSION["neutralizedEmail"]=htmlspecialchars($_SESSION["email"]);
  }else{
    $_SESSION["wrong credentials"]=true;
  }
}elseif ($_POST["button"]==="Register") {
  $_SESSION=[];

  if (($database)->insertAccount($_POST["email"],$_POST["password"])) {
    $_SESSION["successful account creation"]=true;
  }else {
    $_SESSION["email taken"]=true;
  }
}









?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css">
  <title>Log In or Sign Up</title>
</head>
<body>







  <?php if (isset($_SESSION["neutralizedEmail"])) {
    echo "<strong>Welcome back {$_SESSION["neutralizedEmail"]}, thank you for using our service!</strong><br>You can alternatively log in as a different user:";
  }elseif (isset($_SESSION["wrong credentials"])) {
    $_SESSION=[];
    echo "<strong>Sorry wrong credentials, please retry.</strong>";
  }elseif (isset($_SESSION["email taken"])) {
    $_SESSION=[];
    echo "<strong>Email already registered, please log in.</strong>";
  }elseif (isset($_SESSION["successful account creation"])) {
    $_SESSION=[];
    echo "<strong>Account creation successful, please log in.</strong>";
  } ?>
<form action="/indexx.php" method="post" id="form1">
  <label for="email">Email address:</label>
  <input type="text" name="email" value="1234" id="email"><br>
  <label for="password">Password:</label>
  <input type="text" name="password" value="1234" id="password"><br>
  <button type="submit" value="Login" name="button" form="form1"><strong>Login!!</strong></button>
  <input type="submit" value="Register" name="button">
</form>
</body>
</html>
 