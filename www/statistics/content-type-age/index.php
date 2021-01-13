<?php session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');
$isAdmin=false;
if (isset($_SESSION["email"])) {
  $database=new Database();
  if($isAdmin=($database->getAccount_($_SESSION["email"]))["is_admin"]){
    $uniqueContentTypesAgesAverage=$database->getUniqueContentTypesAgesAverage();
    $size=count($uniqueContentTypesAgesAverage);
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
  <h1 class="h3 mb-3 fw-normal">Average date per Content-Type:</h1>
  <div class="container">
  <table class="table">
    <thead>
      <tr>
        <th scope="col"></th>
        <?php for($i=0;$i<$size;++$i):?>
        <th scope="col"><?php echo($uniqueContentTypesAgesAverage[$i]["type"]);?></th>
        <?php endfor;?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Quantity</th>
        <?php for($i=0;$i<$size;++$i):?>
        <td><?php echo($uniqueContentTypesAgesAverage[$i]["age"]);?></td>
        <?php endfor;?>
      </tr>
    </tbody>
  </table>
  </div>
<?php endif?>








<footer class="bd-footer bg-dark text-light fixed-bottom text-center">
  <div class="container">
    <p class="mb-0">Designed for WEB by Spiros, Basilis and Aris</p>
  </div>
</footer>
</body>
</html>


