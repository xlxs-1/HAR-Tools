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
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="container-fluid" id="particles-js" style="  background-image: url(/intro.png); background-size:100%; background-repeat: no-repeat; background-position: 50% 50%; box-shadow: 0 0 32px 32px #f3f3f3 inset;"></div>
      </div>
      <div class="col-md-6">
        <h1 class="h1 mb-3 fw-normal" style="margin-top: 78px;">Har Tools:</h1>
        <h1 class="h3 mb-3 fw-normal">Καλωσορίσατε στην ιστοσελίδα μας!</h1>
        <span>
          <br>
          Μπορείτε να κάνετε upload αρχεία HAR για την ανάλυσή τους.<br>
          Παρέχονται και δίαφορα εργαλεία για το visualization των HAR.
        </span>
      </div>
    </div>
  </div>
  <br><br>
  <script src="/particles/particles.js"></script>
  <script src="/particles/app.js"></script>
  <footer class="bd-footer bg-dark text-light fixed-bottom text-center">
    <div class="container">
      <p class="mb-0">Designed for WEB by Spiros, Basilis and Aris</p>
    </div>
  </footer>
</body>
</html>
