<?php session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');
if (isset($_SESSION["email"])) {
  $database=new Database();
  if (isset($_POST["name"])&&isset($_POST["lastName"])&&isset($_POST["password"])&&isset($_POST["button"])) {
    if (!$error=isPasswordOK($_POST["password"])) {//if password ok
      $ok=$database->updateUser($_SESSION["email"],$_POST["name"],$_POST["lastName"],$_POST["password"]);
    }
  }
  $userAccount=$database->getAccount_($_SESSION["email"]);
}
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
  <link rel="stylesheet" type="text/css" href="/css/style.css"/>
  <link rel="stylesheet" type="text/css" href="/css/sign.css"/>
  <script src="/js/bootstrap.bundle.js"></script>
  <?php if (!isset($_SESSION["email"])):?>
    <script>
    function fn(){ location.replace("/login");}
      setTimeout(fn,750);
    </script>
  <?php endif?>
  <title>Account</title>
</head>
<body class="text-center">
<?php if (isset($_SESSION["email"])):?>
  <?php include ($_SERVER["DOCUMENT_ROOT"]."/../menu.php");?>
  <?php if (isset($error))echo($error);?>
  <h1 class="h3 mb-3 fw-normal">Account</h1>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <h1 class="h4 mb-3 fw-normal">Statistics</h1>
        <main class="form-sign">
          <label>Date last uploaded:</label>
          <input class="form-control me-2" type="text" name="email" value="<?php echo(date_create($userAccount["last_upload"])->format('H:i D d, M Y'));?>" disabled><br>
          <label>Total uploads:</label>
          <input class="form-control me-2" type="text" name="email" value="<?php echo($userAccount["number_of_uploads"]);?>" disabled><br>
          <?php if ($userAccount["is_admin"]):?>
            <label>Users count:</label>
            <input class="form-control me-2" type="text" name="email" value="<?php echo($database->countUsers());?>" disabled><br>
          <?php endif?>
        </main>
      </div>
      <div class="col-md-6">
        <form class="form-sign" action="" method="post" id="form1">
          <h1 class="h4 mb-3 fw-normal">Settings</h1>
          <label for="email">Email address:</label>
          <input class="form-control me-2" type="text" name="email" placeholder="E-mail" value="<?php echo(htmlspecialchars($_SESSION["email"]));?>" id="email" disabled><br>
          <label for="name">Name:</label>
          <input class="form-control me-2" type="text" name="name" placeholder="Name" value="<?php echo(htmlspecialchars($userAccount["name"]));?>" id="name"><br>
          <label for="lastName">Last name:</label>
          <input class="form-control me-2" type="text" name="lastName" placeholder="Last Name" value="<?php echo(htmlspecialchars($userAccount["last_name"]));?>" id="lastName"><br>
          <label for="password">Password:</label>
          <input class="form-control me-2" type="password" name="password" placeholder="Password" value="<?php echo(htmlspecialchars($userAccount["password"]));?>" id="password"><br>
          <label for="password2">Retype Password:</label>
          <input class="form-control me-2" type="password" name="password2" placeholder="Re-type Password" value="<?php echo(htmlspecialchars($userAccount["password"]));?>" id="password2"><br>
          <button class="w-100 btn btn-lg btn-success" type="submit" value="Save" name="button" form="form1" id="button">Save</button>
          <label id="userMessage"></label>
        </form>
        <script src="/passwordCheck.js"></script>
        <script>x=new PasswordValidator("password","password2","userMessage","button");</script>
      </div>
    </div>
  </div>
<?php endif?>

<footer class="bd-footer bg-dark text-light fixed-bottom text-center">
  <div class="container">
    <p class="mb-0">Designed for WEB by Spiros, Basilis and Aris</p>
  </div>
</footer>
</body>
</html>
