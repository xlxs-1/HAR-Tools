<?php session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');
$isAdmin=false;
if (isset($_SESSION["email"])) {
  $database=new Database();
  if($isAdmin=($database->getAccount_($_SESSION["email"]))["is_admin"]){
    $requestMethodStats=$database->getRequestMethodStats();
    $responseStatusStats=$database->getResponseStatusStats();
    $uniqueDomainNames=$database->getUniqueRequestUrls();
    //todo add more later
  }
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
  <?php if (!$isAdmin):?>
    <script>
    function fn(){ location.replace("/");}
      setTimeout(fn,750);
    </script>
  <?php endif?>
  <title>Statistics</title>
</head>
<body class="text-center">
<?php if ($isAdmin):?>
  <?php include ($_SERVER["DOCUMENT_ROOT"]."/../menu.php");?>
  <h1 class="h3 mb-3 fw-normal">Request method Statistics:</h1>
  <table class="table">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Get</th>
        <th scope="col">Head</th>
        <th scope="col">Post</th>
        <th scope="col">Put</th>
        <th scope="col">Delete</th>
        <th scope="col">Connect</th>
        <th scope="col">Option</th>
        <th scope="col">Trace</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Quantity</th>
        <td><?php echo($requestMethodStats["get"]);?></td>
        <td><?php echo($requestMethodStats["head"]);?></td>
        <td><?php echo($requestMethodStats["post"]);?></td>
        <td><?php echo($requestMethodStats["put"]);?></td>
        <td><?php echo($requestMethodStats["delete_"]);?></td>
        <td><?php echo($requestMethodStats["connect"]);?></td>
        <td><?php echo($requestMethodStats["options"]);?></td>
        <td><?php echo($requestMethodStats["trace"]);?></td>
      </tr>
    </tbody>
  </table>
  <br><br><br><br>
  <h1 class="h3 mb-3 fw-normal">Response status Statistics:</h1>
  <table class="table">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">1xx informational response</th>
        <th scope="col">2xx successful</th>
        <th scope="col">3xx redirection</th>
        <th scope="col">4xx client error</th>
        <th scope="col">5xx server error</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Quantity</th>
        <td><?php echo($responseStatusStats["informational"]);?></td>
        <td><?php echo($responseStatusStats["successful"]);?></td>
        <td><?php echo($responseStatusStats["redirection"]);?></td>
        <td><?php echo($responseStatusStats["client_error"]);?></td>
        <td><?php echo($responseStatusStats["server_error"]);?></td>
      </tr>
    </tbody>
  </table>
  <br><br><br><br>
  <h1 class="h3 mb-3 fw-normal">Unique domain names:</h1>
  <table class="table">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Unique domain names</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Quantity</th>
        <td><?php echo($uniqueDomainNames);?></td>
      </tr>
    </tbody>
  </table>
  <br><br><br><br>
  <table class="table">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Unique ISPs</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Quantity</th>
        <td><?php echo($uniqueDomainNames);?></td>
      </tr>
    </tbody>
  </table>
  
<?php endif?>








<footer class="bd-footer bg-dark text-light fixed-bottom text-center">
  <div class="container">
    <p class="mb-0">Designed for WEB by Spiros, Basilis and Aris</p>
  </div>
</footer>
</body>
</html>


