<?php session_start();

if (isset($_POST["email"])&&isset($_POST["password"])&&isset($_POST["button"])&&!isset($_SESSION["email"])) {
  include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');
  $database=new database();
  if ($account=$database->getAccount($_POST["email"],$_POST["password"])) {
    $_SESSION["email"]=$account["email"];
  }else{
    $wrongCredentials=true;
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
  <?php if (isset($wrongCredentials)):?>
    Wrong credentials, please retry.
  <?php endif?>

<main class="form-sign">
  <form action="" method="post" id="form1">
    <h1 class="h3 mb-3 fw-normal">Please Log In</h1>
    <label for="email">Email address:</label>
    <input class="form-control me-2" type="text" name="email" value="1234" id="email" placeholder="E-mail"><br>
    <label for="password">Password:</label>
    <input class="form-control me-2" type="text" name="password" value="1234#A67" id="password" placeholder="Password"><br>
    <button class="w-100 btn btn-lg btn-success" type="submit" value="Login" name="button" form="form1">Log In</button>
    <!--
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>


  </form>


  <form action="" method="post" id="form1">
    <nav class="navbar navbar-light">
      <div class="container-fluid">
        <form class="d-flex">
          <ul class="list-unstyled">
            <li><input class="form-control me-2" type="text" id="email" name="email" placeholder="E-mail" aria-label="E-mail"></li>
            <li><input class="form-control me-2" type="password" id="password" name="password" placeholder="Password" aria-label="Password"></li>
            <input type="submit" class="btn btn-success" value="Login" name="button" form="form1">
          </ul>
        </form>
      </div>
    </nav>
  
-->
  </form>
  <p class="mt-5 mb-3 text-muted">&copy; 2020-2021</p>
</main>
<?php else:?>
  Logged in redirecting...
<?php endif?>


<footer class="bd-footer bg-dark text-light fixed-bottom text-center">
  <div class="container">
    <p class="mb-0">Designed for WEB by Spiros, Basilis and Aris</p>
  </div>
</footer>
</body>
</html>
