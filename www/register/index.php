<?php session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');
if (isset($_POST["password"])&&$error=isPasswordOK($_POST["password"])) {//password !ok, do nothing
  # code...
}elseif (isset($_POST["email"])&&isset($_POST["password"])&&isset($_POST["button"])&&!isset($_SESSION["email"])) {
  $database=new database();
  if ($database->insertAccount($_POST["email"],$_POST["password"])) {
    $_SESSION["email"]=$_POST["email"];
  }else{
    $error="Email already registered, please <a href='/login'>Log In</a>.";
  }
}?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
  <link rel="stylesheet" type="text/css" href="/css/style.css"/>
  <link rel="stylesheet" type="text/css" href="/css/sign.css"/>
  <script src="/js/bootstrap.bundle.js"></script>
  <?php if (isset($_SESSION["email"])):?>
    <script>
    function fn(){ location.replace("/");}
      setTimeout(fn,750);
    </script>
  <?php endif?>
  <title>Welcome</title>
</head>
<body class="text-center">
<?php if (!isset($_SESSION["email"])):?>
  <?php include ($_SERVER["DOCUMENT_ROOT"]."/../menu.php");?>
  <?php if (isset($error))echo($error);?>
<main class="form-sign">
  <form action="" method="post" id="form1">
    <h1 class="h3 mb-3 fw-normal">Please Register</h1>
      <label for="email">Email address:</label>
      <input class="form-control me-2" type="text" name="email" value="1234" id="email" placeholder="E-mail"><br>
      <label for="password">Password:</label>
      <input class="form-control me-2" type="password" name="password" value="1234#A67" id="password" placeholder="Password"><br>
      <label for="password2">Retype Password:</label>
      <input class="form-control me-2" type="password" name="password2" placeholder="Re-type Password" value="1234#A67" id="password2"><br>
      <!--
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      -->
      <button class="w-100 btn btn-lg btn-success" type="submit" value="Register" name="button" form="form1" id="button">Register</button>
      <label id="userMessage"></label>
  </form>
  <script src="/passwordCheck.js"></script>
  <script>x=new PasswordValidator("password","password2","userMessage","button");</script>
</main>
<?php else:?>
  Logged in redirecting...
<?php endif?>



<footer class="bd-footer bg-dark text-light fixed-bottom text-center">
  <div class="container">
    <p class="mb-0">Designed for WEB by Spiros, Basilis and Aris</p>
    <p class="m-0 text-muted">&copy; 2020-2021        todo include this footer in all files</p>
  </div>
</footer>
</body>
</html>
