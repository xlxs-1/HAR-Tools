<?php session_start();$_SESSION=[];?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
  <link rel="stylesheet" type="text/css" href="/css/style.css"/>
  <link rel="stylesheet" type="text/css" href="/css/sign.css"/>
  <script src="/js/bootstrap.bundle.js"></script>
  <title id="titleBar">Please Wait</title>
  <script>
    function fn(){ location.replace("/");}
      setTimeout(fn,2500);
  </script>
</head>
<body class="text-center">
    We are glad you continue to use our services, hope to see you soon.
  <footer class="bd-footer bg-dark text-light fixed-bottom text-center">
    <div class="container">
      <p class="mb-0">Designed for WEB by Spiros, Basilis and Aris</p>
    </div>
  </footer>
</body>
</html>
