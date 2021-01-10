<?php session_start();?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
  <link rel="stylesheet" type="text/css" href="/css/style.css"/>
  <link rel="stylesheet" type="text/css" href="/css/sign.css"/>
  <script src="/js/bootstrap.bundle.js"></script>

  <title>Welcome</title>
</head>
<body>
  <?php echo"Welcome ".(isset($_SESSION["email"])?htmlspecialchars($_SESSION["email"]):"guest").".";?>
  <?php include ($_SERVER["DOCUMENT_ROOT"]."/../menu.php");?>
  <footer class="bd-footer bg-dark text-light fixed-bottom text-center">
    <div class="container">
      <p class="mb-0">Designed for WEB by Spiros, Basilis and Aris</p>
    </div>
  </footer>
</body>
</html>
